<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Utils\CoreUtils;

/**
 * Description of AnalyseController
 *
 * @author tberdy
 */
class AnalyseController extends Controller {

    /**
     * Operation analysePost
     *
     * Returns data about the face of the person.
     *
     *
     * @return Http response
     */
    public function analysePost(Request $request) {
        $input = $request->all();

        //path params validation
        //not path params validation
        if (!isset($input['picture'])) {
            throw new \InvalidArgumentException('Missing the required parameter $picture when calling analysePost');
        }
        $picture = $input['picture'];
        $filepath = CoreUtils::saveFile($picture);

        $result = CoreUtils::curlRequest(CoreUtils::URL . '/detect?returnFaceId=true&returnFaceAttributes=' . htmlspecialchars("emotion"), 'POST', 'application/octet-stream', file_get_contents($filepath));
        
        $emo = "";
        if (!empty($result)) {
            $tmp = $result[0]->faceAttributes->emotion;
            $val = 0;
            
            foreach ($tmp as $key => $value) {
                if ($value > $val) {
                    $emo = $key;
                    $val = $value;
                }
            }
        }      
        
        return response()->json(array(
                    'code' => 200,
                    'msg' => 'OK',
                    'data' => $emo
        ));
    }

}

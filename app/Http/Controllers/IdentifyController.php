<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Utils\CoreUtils;
use App\Utils\FaceUtils;
use App\Utils\PersonUtils;

class IdentifyController extends Controller {

    /**
     * Operation identifyPost
     *
     * Recognize the person on the pictures.
     *
     *
     * @return Http response
     */
    public function identifyPost(Request $request) {
        $input = $request->all();
        if (!isset($input['picture'])) {
            throw new \InvalidArgumentException('Missing the required parameter $picture when calling identifyPost');
        }
        $picture = $input['picture'];
        $filepath = CoreUtils::saveFile($picture);

        $faceId = FaceUtils::detectFace($filepath);

        $result = CoreUtils::curlRequest(CoreUtils::URL . '/identify', 'POST', 'application/json', json_encode(array(
                    "personGroupId" => CoreUtils::GROUP_ID,
                    "faceIds" => array(
                        $faceId
                    ),
                    "maxNumOfCandidatesReturned" => 1,
                    "confidenceThreshold" => 0.4
        )));

        try {
            $personId = $result[0]->candidates[0]->personId;
            $confidence = $result[0]->candidates[0]->confidence;
        } catch (Exception $ex) {
            return response()->json(array(
                        'code' => 400,
                        'msg' => 'ERROR',
                        'data' => $result
            ));
        }

        $name = PersonUtils::getPersonNameFromIds($personId);

        return response()->json(array(
                    'code' => 200,
                    'msg' => 'OK',
                    'data' => array(
                        'name' => $name,
                        'confidence' => $confidence
                    )
        ));
    }

}

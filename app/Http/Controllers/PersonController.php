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
 * Description of PersonController
 *
 * @author tberdy
 */
class PersonController extends Controller {

    /**
     * Operation personGet
     *
     * Get the list of people.
     *
     *
     * @return Http response
     */
    public function personGet() {
        $result = CoreUtils::curlRequest(CoreUtils::URL . '/persongroups/' . CoreUtils::GROUP_ID . '/persons', 'GET', 'application/json', json_encode(array()));

        return response()->json(array(
                    'code' => 200,
                    'msg' => 'OK',
                    'data' => json_decode($result)
        ));
    }

    /**
     * Operation personPost
     *
     * Add a new person to the list.
     *
     *
     * @return Http response
     */
    public function personPost(Request $request) {
        $input = $request->all();
        if (!isset($input['name'])) {
            throw new \InvalidArgumentException('Missing the required parameter $name when calling comparePost');
        }
        $name = $input['name'];

        if (!isset($input['picture'])) {
            throw new \InvalidArgumentException('Missing the required parameter $picture when calling comparePost');
        }
        $picture = $input['picture'];

        $result = CoreUtils::curlRequest(CoreUtils::URL . '/persongroups/' . CoreUtils::GROUP_ID . '/persons', 'POST', 'application/json', json_encode(array('name' => $name)));

        $personId = json_decode($result)->personId;
        $this->personAddFace($personId, $picture);

        return response()->json(array(
                    'code' => 200,
                    'msg' => 'OK',
                    'data' => json_decode($result)
        ));
    }

    /**
     * Operation addPersonFacePost
     *
     * Add a face for the person.
     *
     * @param string $person_id ID of person (required)
     *
     * @return Http response
     */
    public function addPersonFacePost(Request $request, $person_id) {
        $input = $request->all();

        if (!isset($input['picture'])) {
            throw new \InvalidArgumentException('Missing the required parameter $picture when calling comparePost');
        }
        $picture = $input['picture'];

        return $this->personAddFace($person_id, $picture);
    }

    private function personAddFace($personId, $picture) {
        $picturepath = $this->saveFile($picture);

        $result = CoreUtils::curlRequest(CoreUtils::URL . '/persongroups/' . CoreUtils::GROUP_ID . '/persons/' . $personId . '/persistedFaces', 'POST', 'application/octet-stream', file_get_contents($picturepath));

        return response()->json(array(
                    'code' => 200,
                    'msg' => 'OK',
                    'data' => json_decode($result)
        ));
    }

}

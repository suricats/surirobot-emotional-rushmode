<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Utils;

use App\Utils\CoreUtils;

/**
 * Description of PersonUtils
 *
 * @author tberdy
 */
class PersonUtils {

    public static function getPersonNameFromIds($personId) {

        $result = CoreUtils::curlRequest(CoreUtils::URL . '/persongroups/' . CoreUtils::GROUP_ID . '/persons/' . $personId, 'GET', 'application/json', json_encode(array()));

        return $result->name;
    }

}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Utils;

use App\Utils\CoreUtils;

/**
 * Description of FaceUtils
 *
 * @author tberdy
 */
class FaceUtils {

    public static function detectFace(String $filepath) {
        $result = CoreUtils::curlRequest(CoreUtils::URL . '/detect?returnFaceId=true', 'POST', 'application/octet-stream', file_get_contents($filepath));

        return $result[0]->faceId;
    }

}

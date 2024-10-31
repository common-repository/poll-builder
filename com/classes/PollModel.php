<?php
namespace ypl;

class PollModel {
    private static $data = array();

    private function __construct() {
    }

    public static function getDataById($postId) {
        if (!isset(self::$data[$postId])) {
            self::$data[$postId] = Poll::getPostSavedData($postId);
        }

        return self::$data[$postId];
    }
}

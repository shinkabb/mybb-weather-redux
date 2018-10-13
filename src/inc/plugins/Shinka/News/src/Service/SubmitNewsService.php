<?php

require_once MYBB_ROOT . "inc/functions.php";

class Shinka_News_Service_SubmitNewsService 
{
    public static function handle($data = null)
    {
        $data = $data ?: self::shapeData();
        echo "hellooooo";
        $entity = Shinka_News_Entity_News::fromArray($data);
        var_dump($entity);

        if ($entity->isValid()) {
            return Shinka_News_Manager::create($entity);
        }

        self::outputErrors($entity->errors);
        return $entity->errors;
    }

    public static function shapeData() {
        global $mybb;

        return Shinka_News_Entity_News::fromArray(
            array(
                'headline' => $mybb->get_input('headline'),
                'text' => $mybb->get_input('text'),
                'pinned' => $mybb->get_input('pinned', $mybb::INPUT_INT),
                'status' => true ? "APPROVED" : "AWAITING_APPROVAL",
                'user' => $mybb->user,
                'thread' => array(
                    'tid' => $mybb->get_input('tid', $mybb::INPUT_INT)
                )
            )
        );
    }

    public static function outputErrors($err) {
        global $errors;
        $errors = inline_error($err);
    }
}
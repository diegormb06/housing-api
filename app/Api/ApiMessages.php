<?php


namespace App\Api;


use PhpParser\Node\Expr\Array_;

class ApiMessages
{
    private $message = [];

    public function __construct(string $message, array $data = [])
    {
        $this->message['message'] = $message;
        $this->message['errors'] = $data;
    }

    public function getMessage() {
        return $this->message;
    }

}

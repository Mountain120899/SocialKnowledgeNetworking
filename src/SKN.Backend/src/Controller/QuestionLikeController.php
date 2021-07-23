<?php
namespace Src\Controller;

use Src\TableGateways\QuestionLikeGateway;

class QuestionLikeController {

    private $db;
    private $requestMethod;
    private $question_id;

    private $QuestionLikeGateway;

    public function __construct($db, $requestMethod, $question_id)
    {
        $this->db = $db;
        $this->requestMethod    = $requestMethod;
        $this->question_id      = $question_id;
        $this->QuestionLikeGateway = new QuestionLikeGateway($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':     
                $response = $this->getQuestionLike($this->question_id);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    private function getQuestionLike($question_id)
    {
        $result = $this->QuestionLikeGateway->find($question_id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function validateInput($input)
    {
        return true;
    }

    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}
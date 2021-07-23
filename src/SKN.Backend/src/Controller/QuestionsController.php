<?php
namespace Src\Controller;

use Src\TableGateways\QuestionsGateway;

class QuestionsController {

    private $db;
    private $requestMethod;
    private $questionId;

    private $questionGateway;

    public function __construct($db, $requestMethod, $questionId)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->questionId = $questionId;

        $this->questionGateway = new questionsGateway($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->questionId == 1) {
                    $response = $this->getRecentQuestion();
                } 
                else if ($this->questionId == 2) {
                    $response = $this->getQuestionHavingMostAnswer();
                }
                else if ($this->questionId == 3) {
                    $response = $this->getQuestionWithoutAnswer();
                }
                else {
                    $response = $this->getquestion($this->questionId);
                }
                if(!$this->questionId) {
                    $response = $this->getAllQuestions();
                }
                break;
            case 'POST':
                $response = $this->createquestionFromRequest();
                break;
            case 'PUT':
                $response = $this->updatequestionFromRequest($this->questionId);
                break;
            case 'DELETE':
                $response = $this->deletequestion($this->questionId);
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

    private function getAllQuestions()
    {
        $result = $this->questionGateway->findAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getquestion($id)
    {
        $result = $this->questionGateway->find($id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getRecentQuestion()
    {
        $result = $this->questionGateway->findRecentQuestion();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getQuestionHavingMostAnswer()
    {
        $result = $this->questionGateway->findQuestionHavingMostAnswer();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getQuestionWithoutAnswer()
    {
        $result = $this->questionGateway->findQuestionWithoutAnswer();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function validatequestion($input)
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
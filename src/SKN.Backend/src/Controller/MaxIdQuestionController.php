<?php

    namespace Src\Controller;

    use Src\TableGateways\MaxIdQuestionGateway;

    class MaxIdQuestionController{
        private $db;
        private $requestMethod;

        private $MaxIdQuestionGateway;

        public function __construct($db, $requestMethod){
            $this->db = $db;
            $this->requestMethod = $requestMethod;

            $this->MaxIdQuestionGateway = new MaxIdQuestionGateway($db);
        }

        public function processRequest(){
            switch($this->requestMethod){
                case 'GET':
                    $response = $this->getMaxIdQuestion();
                    break;
                default:
                    $response = $this->notFoundResponse();
                    break;
            }
            header($response['status_code_header']);
            if ($response['body']){
                print $response['body'];
            }
        }

        private function getMaxIdQuestion(){
            $result = $this->MaxIdQuestionGateway->findMax();
            $response['status_code_header'] = "HTTP/1.1 200 ok";
            $response['body'] = json_encode($result);
            return $response;
        }

        private function validateMaxIdQuestion(){
            return true;
        }

        private function unprocessableEntityResponse(){
            $response['status_code_header'] = "HTTP/1.1 422 Unprocessable Entity";
            $response['body'] = Json_encode(array(
                "error" => "Invalid input"
            ));
            return $response;
        }

        private function notFoundResponse(){
            $response['status_code_header'] = "HTTP/1.1 404 not found";
            $response['body'] = null;
            return $response;
        }

    }
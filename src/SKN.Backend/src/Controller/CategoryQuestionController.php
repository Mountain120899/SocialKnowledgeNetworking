<?php

    namespace Src\Controller;

    use Src\TableGateways\CategoryQuestionGateway;
    use Src\TableGateways\QuestionGateway;

    class CategoryQuestionController{
        private $db;
        private $requestMethod;
        private $CategoryQuestionId;

        private $CategoryCategoryQuestionGateway;

        public function __construct($db, $requestMethod, $CategoryQuestionId){
            $this->db = $db;
            $this->requestMethod = $requestMethod;
            $this->CategoryQuestionId = $CategoryQuestionId;

            $this->CategoryQuestionGateway = new CategoryQuestionGateway($db);
        }

        public function processRequest(){
            switch($this->requestMethod){
                case 'GET':
                    if($this->CategoryQuestionId){
                        if (ctype_digit($this->CategoryQuestionId)){
                            $response = $this->getCategoryQuestion($this->CategoryQuestionId);
                        }else{
                            //VD: tìm câu hỏi theo category_id = 1
                            //url = localhost:8000/categoryquestion/category_id=1
                            //giá trị sau dấu "=" không được có khoảng trắng
                            $response = $this->getByRequest($this->CategoryQuestionId);                        }
                        
                    } else{
                        $response = $this->getAllCategoryQuestions();
                    };
                    break;
                case 'POST':
                    $response = $this->createCategoryQuestionFromRequest();
                    break;
                case 'PUT':
                    $response = $this->updateQuestionFromRequest($this->CategoryQuestionId);
                    break;
                case 'DELETE':
                    $response = $this->deleteQuestion($this->CategoryQuestionId);
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

        private function getAllCategoryQuestions(){
            $result = $this->CategoryQuestionGateway->findAll();
            $response['status_code_header'] = "HTTP/1.1 200 ok";
            $response['body'] = json_encode($result);
            return $response;
        }

        private function getCategoryQuestion($id){
            $result = $this->CategoryQuestionGateway->find($id);
            if (! $result) {
                return $this->notFoundResponse();
            }
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($result);
            return $response;
        }


        private function getByRequest($CategoryQuestionId){
            $pos = strpos($CategoryQuestionId, '=');
            $field = substr($CategoryQuestionId, 0, $pos);
            $new_id = substr($CategoryQuestionId, $pos+1, strlen($CategoryQuestionId));
            $questionid_list = $this->CategoryQuestionGateway->findByRequest($field, $new_id);
            $question_list = array();
            foreach($questionid_list as $questid){
                $id =  $questid['question_id'];
                $question = new QuestionGateway($this->db);
                $question = $question->find($id);

                $question = json_encode($question);
                $question = substr($question, 1, strlen($question) - 2);

                $question = json_decode($question);
                array_push($question_list, $question);
            }
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($question_list);
            return $response;
        }

        private function createCategoryQuestionFromRequest(){
            $input = (array) json_decode(file_get_contents('php://input'), TRUE);
           
            if (!$this->validateCategoryQuestion($input)){
                return $this->unprocessableEntityResponse();
            }
            $this->CategoryQuestionGateway->insert($input);
            $response['status_code_header'] = "HTTP/1.1 201 created";
            $response['body'] = "inserted";
            return $response;
        }

        private function updateQuestionFromRequest($id){
            $result = $this->CategoryQuestionGateway->find($id);
            if(!$result){
                return $this->notFoundResponse();
            }

            $input = (array) json_decode(file_get_contents('php://input'), TRUE);
            if (!$this->validateCategoryQuestion($input)){
                return $this->unprocessableEntityResponse();
            }
            $this->CategoryQuestionGateway->update($id, $input);
            $response['status_code_header'] = "HTTP/1.1 200 ok";
            $response['body'] = "updated";
            return $response;
        }

        private function deleteQuestion($id){
            $result = $this->CategoryQuestionGateway->find($id);
            if (!$result){
                return $this->notFoundResponse();
            }

            $this->CategoryQuestionGateway->delete($id);
            $response['status_code_header'] = "HTTP/1.1 200 ok";
            $response['body'] = "deleted";
            return $response;
        }

        private function validateCategoryQuestion(){
            // if (isset($input['questionid'])){
            //     if (!ctype_digit($input['title'])){
            //         return false;
            //     }
            // }
            // if (isset($input['shortencontent'])){
            //     if (!ctype_alnum($input['title'])){
            //         return false;
            //     }
            // }
            // if (isset($input['fullcontent'])){
            //     if (!ctype_alnum($input['title'])){
            //         return false;
            //     }
            // }
            // if (isset($input['user'])){
            //     if (!ctype_alnum($input['title'])){
            //         return false;
            //     }
            // }
            // if (isset($input['status'])){
            //     if (!ctype_digit($input['title'])){
            //         return false;
            //     }
            // }
            // if (isset($input['imagelink'])){
            //     if (!ctype_alnum($input['title'])){
            //         return false;
            //     }
            // }
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
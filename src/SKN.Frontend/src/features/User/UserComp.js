import { useState } from 'react';
import { Link } from 'react-router-dom';
import ListGroup from 'react-bootstrap/ListGroup';
import { Button, Container, Col, Row, Nav, Tab, Tabs, Card } from 'react-bootstrap';
import "../../app/styles/User.css";
export default function User(props) {
    const questioncount = 20;
    const answercount = 11;
    const like = 20;
    const points = 20;
    return (
        <Container>
            <Row style={{ height: "200px" }} >
                <img src={process.env.PUBLIC_URL + "./images/default-user-icon.png"}
                    style={{ width: "100px", margin: "auto 0", height: "100px" }}
                    alt="Đây là logo" />
                <h3 style={{
                    margin: "auto 20px",
                    fontWeight: "bold",
                    color: "black",
                    width: "auto"
                }
                }>Rhea</h3>
            </Row>
            <Row style={{ height: "auto" }} fuild>
                <Container>
                    <Tabs defaultActiveKey="home" id="noanim-tab-example" className="mb-3">
                        <Tab eventKey="home" title="About">
                            <Container>
                                <Row xs={1} md={4}  >
                                    <Col>
                                        <Card>
                                            <Card.Body>
                                                <img src={process.env.PUBLIC_URL + "./images/question.png"}
                                                    style={{ width: "20px", "vertical-align": "middle", height: "20px" }} ></img>
                                                <span style={{ "vertical-align": "middle", marginLeft: "7px" }}>
                                                    {questioncount} Questions
                                                </span>
                                            </Card.Body>
                                        </Card>
                                    </Col>
                                    <Col>
                                        <Card>
                                            <Card.Body>
                                                <img src={process.env.PUBLIC_URL + "./images/comment.png"}
                                                    style={{ width: "20px", "vertical-align": "middle", height: "20px" }} ></img>
                                                <span style={{ "vertical-align": "middle", marginLeft: "7px" }}>
                                                    {answercount} Answers
                                                </span>
                                            </Card.Body>
                                        </Card>
                                    </Col>
                                    <Col>
                                        <Card>
                                            <Card.Body>
                                                <img src={process.env.PUBLIC_URL + "./images/like.png"}
                                                    style={{ width: "20px", "vertical-align": "middle", height: "20px" }} ></img>
                                                <span style={{ "vertical-align": "middle", marginLeft: "7px" }}>
                                                    {like} Likes
                                                </span>
                                            </Card.Body>
                                        </Card>
                                    </Col>
                                    <Col>
                                        <Card>
                                            <Card.Body>
                                                <img src={process.env.PUBLIC_URL + "./images/points.png"}
                                                    style={{ width: "20px", "vertical-align": "middle", height: "20px" }} 
                                                    alt=""
                                                    ></img>
                                                <span style={{ "vertical-align": "middle", marginLeft: "7px" }}>
                                                    {points} point
                                                </span>
                                            </Card.Body>
                                        </Card>
                                    </Col>
                                     </Row>
                            </Container>
                        </Tab>
                        <Tab eventKey="Questions" title="Questions">
                            <Container>
                                <Question></Question>
                                <Question></Question>
                                <Question></Question>
                            </Container>
                        </Tab>
                        <Tab eventKey="Answers" title="Answers">
                            <Container>
                                <Answer></Answer>
                                <Answer></Answer>
                                <Answer></Answer>
                            </Container>
                        </Tab>
                    </Tabs>
                </Container>
            </Row>
        </Container>
    )
}
export function Question(props){
    return(
        <Card>
            <Card.Header>
                <Link href="">
                    <h5 style={{ margin: "auto" }}>
                    Làm thế nào để qua môn ?
                    </h5>
                </Link>
            </Card.Header>
            <Card.Body style={{ padding: "10px" }}>
                Tôi còn 4 ngày và bí code reactjs ai đó hãy giúp tôi LOL
            </Card.Body>
            <Card.Body style={{ padding: "5px 0px" }}>
                <Container>
                    <span>0 câu trả lời</span>
                    <span style={{ float: "right" }}>Ngày 19 tháng 5 năm 2019</span>
                </Container>
            </Card.Body>
        </Card>
    )
}
export function Answer(props){
    return(
        <Card style={{ marginBottom: "5px" }}>
            <Card.Header>
                <Link href="">
                    <span style={{ margin: "auto" }}>
                        Trả lời cho câu hỏi của "Núi"
                    </span>
                </Link>
                <span style={{ float: "right" }}>Ngày 19 tháng 5 năm 2019</span>
            </Card.Header>
            <Card.Body style={{ padding: "10px" }}>
                Bạn cần làm gì đó
            </Card.Body>
        </Card>
    )
}

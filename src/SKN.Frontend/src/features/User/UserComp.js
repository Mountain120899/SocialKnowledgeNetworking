import {useState, useEffect} from 'react';
import { NavLink } from 'react-router-dom';
import { Button, Container, Col, Row, Tab, Tabs, Card } from 'react-bootstrap';
import { useStore } from "../../app/stores/store";
import { useAuth0 } from "@auth0/auth0-react";
import "../../app/styles/User.css";
export default function User({match}) {
    const { user } = useAuth0();
    const questioncount = 20;
    const answercount = 11;
    const like = 20;
    const { userInfomationStore } = useStore();
    const { getUserInfomation} = userInfomationStore;
    var [questionList, setQuestion] = useState([]);
    var [answerList, setAnswer] = useState([]);
    var [points, setPoint] = useState([]);
    console.log(process.env.PUBLIC_URL);
    async function getAnswerNotVerify(username) {
    try {
        var Type = { RequestType: 1 };
      await getUserInfomation(username,Type).then((question) => {
        console.log(question);
        setQuestion(question);
      });
    } catch {
        setQuestion([]);
      console.log("Lỗi getListQuestion");
    }
    try {
        var Type = { RequestType: 2 };
        await getUserInfomation(username,Type).then((answer) => {
            console.log(answer);
            setAnswer(answer);
        });
      } catch {
        setAnswer([]);
        console.log("Lỗi getListAnswer");
      }
      try {
        var Type = { RequestType: 3 };
        await getUserInfomation(username,Type).then((pointsc) => {
            console.log(pointsc);
            if(pointsc.length==0)
            setPoint(0);
            else
            setPoint(pointsc);
        });
      } catch {
        setPoint(0);
        console.log("Lỗi getPoint");
      }
  }
    useEffect(() => {
        getAnswerNotVerify(match.params.username);
    }, [match.params.username]);
    return (
        <Container>
            <Row style={{ height: "200px" }} >
                <img src={"/images/default-user-icon.png"}
                    style={{ width: "100px", margin: "auto 0", height: "100px" }}
                    alt="Đây là logo" />
                <h3 style={{
                    margin: "auto 20px",
                    fontWeight: "bold",
                    color: "black",
                    width: "auto"
                }
                }>{match.params.username.split('@').slice(0, -1).join('@')}</h3>
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
                                                <img src={"/images/question.png"}
                                                    style={{ width: "20px", "vertical-align": "middle", height: "20px" }} ></img>
                                                <span style={{ "vertical-align": "middle", marginLeft: "7px" }}>
                                                    {questionList.length} Questions
                                                </span>
                                            </Card.Body>
                                        </Card>
                                    </Col>
                                    <Col>
                                        <Card>
                                            <Card.Body>
                                                <img src={"/images/comment.png"}
                                                    style={{ width: "20px", "vertical-align": "middle", height: "20px" }} ></img>
                                                <span style={{ "vertical-align": "middle", marginLeft: "7px" }}>
                                                    {answerList.length} Answers
                                                </span>
                                            </Card.Body>
                                        </Card>
                                    </Col>
                                    <Col>
                                        <Card>
                                            <Card.Body>
                                                <img src={"/images/points.png"}
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
                            {questionList?.map((item) => (<Question item={item}></Question>))}
                            </Container>
                        </Tab>
                        <Tab eventKey="Answers" title="Answers">
                        <Container>
                            {questionList?.map((item) => (<Answer item={item}></Answer>))}
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
                <NavLink to={`/questions/${props.item.id}`}>
                    <span style={{ margin: "auto" }}>
                    {props.item.title}
                    </span>
                </NavLink>
                <span style={{ float: "right" }}>{props.item.created_at}</span>
            </Card.Header>
            <Card.Body style={{ padding: "10px" }}>
                {props.item.content}
            </Card.Body>
        </Card>
    )
}
export function Answer(props){
    return(
        <Card style={{ marginBottom: "5px" }}>
            <Card.Header>
                <NavLink to={`/questions/${props.item.question_id}`} >
                    <span style={{ margin: "auto" }}>
                    {props.item.username} đã trả lời cho một câu hỏi
                    </span>
                </NavLink>
                <span style={{ float: "right" }}>{props.item.created_at}</span>
            </Card.Header>
            <Card.Body style={{ padding: "10px" }}>
                {props.item.content}
            </Card.Body>
        </Card>
    )
}

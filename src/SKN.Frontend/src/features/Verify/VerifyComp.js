import { useState, useEffect } from "react";
import "../../app/styles/Verify.css";
import { useStore } from "../../app/stores/store";
import {
  Button,
  Container,
  Col,
  Row,
  Tab,
  Tabs,
  Card,
  Form,
} from "react-bootstrap";
const data = [
  {
    id: "1",
    title: "Đây là tiêu đề câu hỏi số 4",
    content: "Đây là nội dung câu hỏi số 4",
    status: "1",
    username: "David@gmail.com",
    created_at: "2021-05-12 00:00:00",
  },
];

export default function Verify(props) {
  const [answerstate, setAS] = useState(false);
  const [questionstate, setQS] = useState(false);
  const { verifyStore, settingStore } = useStore();
  const { getSetting, updateSetting } = settingStore;
  const { getanswer } = verifyStore;
  const [autoVerify, setAutoVerify] = useState(false);
  var [answer, setAnswer] = useState([]);
  async function getAnswerNotVerify() {
    try {
      await getanswer(1).then((answer) => {
        console.log(answer);
        console.log(1);
        setAnswer(answer);
      });
    } catch {
      setAnswer([]);
      console.log("Lỗi getListAnswer");
    }
  }
  var [content, setContent] = useState([]);
  async function getQuestionNotVerify() {
    try {
      const response = await fetch(`http://localhost:8000/questionnotverify/1`);
      const json = await response.json();
      setContent(json);
    } catch {
      setContent([]);
      console.log("Lỗi getRaectQuestion");
    }
  }
  const getAutoVerify = async () => {
      const auto = await getSetting("AutoVerify");
      await setAutoVerify(auto.setting_value === "True");
  };

  const settingAutoVerify = async () => {
    const auto = await getSetting("AutoVerify");
    const isAuto = auto.setting_value === "True";
    setAutoVerify(!isAuto);
    await updateSetting({
        setting_name: "AutoVerify",
        setting_value: isAuto ? "False" : "True",
      });
  };

  useEffect(() => {
    getQuestionNotVerify();
    getAnswerNotVerify();
    getAutoVerify();
  }, [questionstate, answerstate,autoVerify]);

  return (
    <Container>
      <Tabs
        defaultActiveKey="question"
        id="noanim-tab-example"
        className="mb-3"
      >
        <Tab eventKey="question" title="Câu Hỏi">
          <Container>
            {content?.map((item) => (
              <OneQuestionTab item={item} setQS={setQS}></OneQuestionTab>
            ))}
          </Container>
        </Tab>
        <Tab eventKey="answer" title="Câu Trả Lời">
          <Container>
            {answer?.map((item) => (
              <OneAnswerTab item={item} setAS={setAS}></OneAnswerTab>
            ))}
          </Container>
        </Tab>
        <Tab eventKey="setting" title={"Cài đặt kiểm duyệt"}>
          <Form.Check
            id = "autoVerifyCheckbox"
            type="checkbox"
            defaultChecked={autoVerify}
            checked={autoVerify}
            onChange={settingAutoVerify}
            label="Tự động duyệt câu hỏi và câu trả lời."
          />
        </Tab>
      </Tabs>
    </Container>
  );
}

export function OneQuestionTab(props) {
  const { verifyStore } = useStore();
  const { verify } = verifyStore;
  const UpdateVerify = (id, type, status) => {
    var verifyInformation = { id: id, type: type, status: status };
    console.log(verifyInformation);
    verify(verifyInformation);
    if (type == 1) {
      props.setQS((bool) => !bool);
    }
  };

  return (
    <Row md="1">
      <Card className={"question-card"}>
        <Card.Header className={"question-header"}>
          <Row>
            <Col className={"question-header-content"}>
              <span>{props.item.username} đã đặt một câu hỏi</span>
              {/* <span>{props.username} đã đặt một câu hỏi</span> */}
            </Col>
            <Col className={"question-header-button"}>
              <Button
                variant="danger"
                id={props.item.id}
                onClick={() => UpdateVerify(props.item.id, 1, 2)}
              >
                <i class="fa fa-times" aria-hidden="true" />
              </Button>
              <Button
                variant="primary"
                id={props.item.id}
                onClick={() => UpdateVerify(props.item.id, 1, 1)}
              >
                <i class="fa fa-check" />
              </Button>
            </Col>
          </Row>
        </Card.Header>
        <Card.Body className={"question-body"}>
          {props.item.content}
          {/*props.content*/}
        </Card.Body>
      </Card>
    </Row>
  );
}
export function OneAnswerTab(props) {
  const { verifyStore } = useStore();
  const { verify } = verifyStore;
  const UpdateVerify = (id, type, status) => {
    var verifyInformation = { id: id, type: type, status: status };
    console.log(verifyInformation);
    verify(verifyInformation);
    if (type == 2) {
      props.setAS((bool) => !bool);
    }
  };

  return (
    <Row md="1">
      <Card className={"answer-card"}>
        <Card.Header class="answer-header">
          <Row>
            <Col className={"answer-header-content"}>
              {/* {Đính kèm link câu hỏi ở đây} */}
              {/* <span >Rhea đã trả lời cho một câu hỏi của Núi</span> */}
              <span>{props.item.username} đã trả lời cho một câu hỏi</span>
            </Col>
            <Col className={"answer-header-button"}>
              <Button
                variant="danger"
                onClick={() => UpdateVerify(props.item.id, 2, 2)}
              >
                <i class="fa fa-times" aria-hidden="true"></i>
              </Button>
              <Button
                variant="primary"
                onClick={() => UpdateVerify(props.item.id, 2, 1)}
              >
                <i class="fa fa-check" />
              </Button>
            </Col>
          </Row>
        </Card.Header>
        <Card.Body className={"answer-body"}>
          {/* Đây là câu trả lời cho câu hỏi. */}
          {props.item.full_content}
        </Card.Body>
      </Card>
    </Row>
  );
}

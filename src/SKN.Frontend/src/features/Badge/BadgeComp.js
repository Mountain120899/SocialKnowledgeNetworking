import { useState } from 'react';
import { Link } from 'react-router-dom';
import ListGroup from 'react-bootstrap/ListGroup';
import { Button, Container, Col, Row, Nav, Tab, Tabs, Card } from 'react-bootstrap';

const data = [{
    point:1,
    detail:'Nhận được khi ai đó thích câu trả lời của bạn.'
},
{
    point:2,
    detail:'Nhận được khi trả lời một câu hỏi.'
},
{
    point:1,
    detail:'Nhận được khi đặt một câu hỏi.'
},
{
    point:1,
    detail:'Nhận được khi ai đó thích câu trả lời của bạn.'
}]

export default function  Badges(props){

    return(
        <Container>
            <Row xs={1} md={4} >
            {
                data.map((item) =><BadgeCard item={item}></BadgeCard>)
            }
            </Row>
        </Container> 
    )
}

export function BadgeCard(props){
    return(
        <Col>
            <Card style={{ margin: "5px",height:"150px" }} >
                <Card.Header>
                <img src="/images/points.png"
                                                    style={{ width: "24px", "vertical-align": "middle", height: "24px" }} ></img>
                    <span style={{ "vertical-align": "middle",marginLeft:"10px"}}>{props.item.point} Điểm</span>
                </Card.Header>
                <Card.Body style={{ padding: "10px" }}>
                    {props.item.detail}
                </Card.Body>
            </Card>
        </Col>
    )
}
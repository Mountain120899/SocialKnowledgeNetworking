import {useState, useEffect} from 'react';
import {Link} from 'react-router-dom';
import ListGroup from 'react-bootstrap/ListGroup';
import {Container,Col,Row,Navbar} from 'react-bootstrap';

import "../../app/styles/Right-menu.css";
import { useAuth0 } from "@auth0/auth0-react";

export default function RightMenuComp(props){
    const [Infor,setInfor] = useState([{questions:"", answers:"", users:""}]);
    const [User,setUser] = useState([]);
    const { user, isAuthenticated, isLoading } = useAuth0();

    async function getInfor() {
        try{
            const response = await fetch('http://localhost:8000/rightmenu/1');
            const json = await response.json();
            setInfor(json);
          }
          catch{
            console.log("Lỗi getInfor");
        }
    }

    async function getUser() {
        try{
            const response = await fetch('http://localhost:8000/rightmenu/2');
            const json = await response.json();
            setUser(json);
          }
          catch{
            console.log("Lỗi getUser");
        }
    }

    useEffect(() => {
        getInfor();
        getUser();
    }, []);

    return(
        <div className="right-menu">
            <TopInformation Infor={Infor}/>
            {
                isAuthenticated ?    
                <Link to = '/create-question'>
                    <button>Tạo câu hỏi</button>
                </Link>
                :
                <Link to = '/sign-in'>
                    <button>Tạo câu hỏi</button>
                </Link>
            }
            <hr/>
            <RankingComp user={User}/>
        </div>
    )
}

export function TopInformation({Infor}){
    return(
        <div className="TopInformation">
            <ul>
                <li>Questions <p>{Infor[0].questions}</p></li>
                <li>Answers <p>{Infor[0].answers}</p></li>
                <li>Users <p>{Infor[0].users}</p></li>
            </ul>
        </div>
    )
}

export function RankingComp({user}){
    return(
        <div className="Ranking">
            <div className="Top-user">
                <img src={process.env.PUBLIC_URL + "./images/multy-user.png"} alt="Đây là multi user"/>
                <p>Top user</p>
            </div>
            <hr/>
            <ListGroup>
            {
                user.map((item, index) =>
                <div key={index}>
                    <UserProfileComp user={item}/>
                </div>    
                )
            }
            </ListGroup>
        </div>
    )
}

export function UserProfileComp({user}){
    return(
        <Container className="UserProfile" fuild>
            <Row>
                <Col xs="0" style={{width:'50px','marginLeft':'-15px', 'marginRight':'10px'}} ><img src={process.env.PUBLIC_URL + "./images/default-user-icon.png"} alt="Đây là multy user"/></Col>
                <Col>
                    <Row ><Navbar.Text variant="green" >{user.username}</Navbar.Text></Row>
                    <Row>{user.final_point} Points</Row>
                </Col>
            </Row>
        </Container>
    )
}

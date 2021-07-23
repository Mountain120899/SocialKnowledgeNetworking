
import "../../app/styles/Home.css";

import {DependentQuestion,APIQuestion} from '../Questions/QuestionComp.js';
import {useState, useEffect, useContext} from 'react';

const api_url = process.env.REACT_APP_API;

export default function Home(props){
    var [content,setContent] = useState([]);

    const Click = (e) => {
        // Lấy câu hỏi theo ̀5 yêu cầu
        let list = document.getElementsByClassName("home-list-line");
        for(let i = 0; i < list.length; i++){
            list[i].className = 'home-list-line';
        } 
        if(e.target.localName === 'li')
        {
            e.target.lastChild.className = 'home-list-line home-line-active'; 
        }
        else{
            e.target.parentElement.lastChild.className = 'home-list-line home-line-active'; 
        }
        var condition = e.target.innerHTML;

        switch(condition) {
            case "Gần đây":{
                getRecentQuestion();
                break;
            }
            case "Nhiều trả lời nhất":{
                getQuestionHavingMostAnswer();
                break;
            }
            case "Chưa có câu trả lời":{
                findQuestionWithoutAnswer();
                break;
            }
        }

    }

    async function getQuestion() {
        try{
            const response = await fetch('http://localhost:8000/questions');
            const json = await response.json();
            setContent(json);
          }
          catch{
            console.log("Lỗi getQuestion");
        }
    }

    async function getRecentQuestion() {
        try{
            const response = await fetch(`http://localhost:8000/questions/1`);
            const json = await response.json();
            setContent(json);
          }
          catch{
            console.log("Lỗi getRecentQuestion");
        }
    }

    async function getQuestionHavingMostAnswer() {
        try{
            const response = await fetch(`http://localhost:8000/questions/2`);
            const json = await response.json();
            setContent(json);
          }
          catch{
            console.log("Lỗi getQuestionHavingMostAnswer");
        }
    }

    async function findQuestionWithoutAnswer() {
        try{
            const response = await fetch(`http://localhost:8000/questions/3`);
            const json = await response.json();
            setContent(json);
          }
          catch{
            console.log("Lỗi findQuestionWithoutAnswer");
        }
    }

    useEffect(() => {
        getQuestion();
    }, []);
    return(
        <div className="home">
            <ul className="home-list">
                <li onClick={Click}>
                    <span>Gần đây</span>
                    <span className="home-list-line"></span>
                </li>
                <li onClick={Click}>
                    <span>Nhiều trả lời nhất</span>
                    <span className="home-list-line"></span>
                </li>
                <li onClick={Click}>
                    <span>Chưa có câu trả lời</span>
                    <span className="home-list-line"></span>
                </li>
            </ul>
            {
                content.map(question => <DependentQuestion props={question} key={question.id}/>)
            }
        </div>
    )
}

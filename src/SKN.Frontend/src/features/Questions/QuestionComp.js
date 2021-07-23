import "../../app/styles/Question.css";
import {NavLink} from 'react-router-dom';
import {useState, useEffect} from 'react';
import { useAuth0 } from "@auth0/auth0-react";

const api_url = process.env.REACT_APP_API;

export default function Questions(props){
    //Lấy category
    var [category, setCategory] = useState([{category_name: "Tất cả"}]);
    var [content, setContent] = useState([]);

    async function getQuestionByCategory(id) {
        try{
            const response = await fetch(`http://localhost:8000/category/${id}`);
            const json = await response.json();
            setContent(json);
          }
          catch{
            console.log("Lỗi getQuestionByCategory");
            setContent([]);
        }
    }

    async function getCategory() {
        try{
            const response = await fetch('http://localhost:8000/category');
            const json = await response.json();
            setCategory(json);
          }
          catch{
            console.log("Lỗi getCategory");
        }
    }

    function handlegetQuestionByCategory() {
        var selected = document.getElementById('category').value;
        getQuestionByCategory(selected);
        console.log(selected);
    }

    useEffect(() => {
        getQuestionByCategory(1);
        getCategory();
    }, []);
    // lấy dữ liệu theo category
    return(
        <div>
            <div className="question">
                <i id="home-icon" class="fas fa-home"></i>
                <span>
                    <NavLink to={`/`}> Trang chủ </NavLink>
                     / 
                    <NavLink to={`/questions`}> Câu hỏi </NavLink>
                </span>

                <select id="category" name="category" onChange = {handlegetQuestionByCategory}>
                    {
                        category.map((item, index) =>
                            <option value={index + 1} key={index}>{item.category_name}</option>
                        )
                    }
                </select>
            </div>
            {
                content.map(question => <DependentQuestion props={question} key={question.id}/>) 
            }     
        </div>
    )
}
// Câu hỏi mà không kèm theo câu trả lời
export function DependentQuestion({props}){
    //const {user} = useContext(UserContext);
    const { user, isAuthenticated, isLoading } = useAuth0();

    const [reactquestion, setReactQuestion] = useState([]);
    const [likeNumber, setlikeNumber] = useState([{like_number: 0}]);
    const [condition, setCondition] = useState(true);

    const handleLike = async() => {
        if (reactquestion.find(value => value.username === user.email) === undefined) {
            let data = {username: user.email, question_id: props.id, is_like: 1};
            await createLike(data);
        }
        else{
            let id = reactquestion.find(value => value.username === user.email).id;
            await deleteLike(id);
        }

        setCondition(pre => !pre);
    }
    
    async function createLike(data) {
        // Default options are marked with *
        const response = await fetch('http://localhost:8000/reactquestion/', {
          method: 'POST', // *GET, POST, PUT, DELETE, etc.
          mode: 'cors', // no-cors, *cors, same-origin
          cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
          credentials: 'same-origin', // include, *same-origin, omit
          headers: {
            'Content-Type': 'application/json'
            // 'Content-Type': 'application/x-www-form-urlencoded',
          },
          redirect: 'follow', // manual, *follow, error
          referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
          body: JSON.stringify(data) // body data type must match "Content-Type" header
        });
    }

    async function deleteLike(id) {
        // Default options are marked with *
        const response = await fetch(`http://localhost:8000/reactquestion/${id}`, {
          method: 'DELETE', // *GET, POST, PUT, DELETE, etc.
          mode: 'cors', // no-cors, *cors, same-origin
          cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
          credentials: 'same-origin', // include, *same-origin, omit
          headers: {
            'Content-Type': 'application/json'
            // 'Content-Type': 'application/x-www-form-urlencoded',
          },
          redirect: 'follow', // manual, *follow, error
          referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
        });
    }

    async function getReactQuestion() {
        try{
            const response = await fetch(`http://localhost:8000/reactquestion/${props.id}`);
            const json = await response.json();
            setReactQuestion(json);
          }
          catch{
            console.log("Lỗi getReactQuestion" + props.id);
            setReactQuestion([]);
        }
    }

    async function getQuestionLike() {
        try{
            const response = await fetch(`http://localhost:8000/questionlike/${props.id}`);
            const json = await response.json();
            setlikeNumber(json);
          }
          catch{
            console.log("Lỗi getQuestionLike");
            setReactQuestion([]);
        }
    }
  
    useEffect(async() => {
        await getReactQuestion();
        await getQuestionLike();
    }, [condition]);

    if(!isAuthenticated){
        return(
            <div className="question">
                <div>
                    <i class="far fa-user"></i>
                </div>
                <div className="question-content">
                    <span>{props.username}</span>
                    Ngày tạo:<span> {props.created_at}</span>
                    Danh mục:<span> {props.category_name}</span>
                    <h4>
                        <NavLink to={`/questions/${props.id}`}>{props.title}</NavLink>
                    </h4>
                    <p>{props.content}</p>
                    <div>
                        <span><i class="fas fa-comment-alt"></i>{props.AnswerCount} Câu trả lời</span>
                        <span>{likeNumber[0].like_number} Like</span>
                    </div>
                </div>
            </div>
        )
    }
    else{
        return(
            <div className="question">
                <div>
                    <i class="far fa-user"></i>
                </div>
                <div className="question-content">
                    <span>{props.username}</span>
                    Ngày tạo:<span> {props.created_at}</span>
                    Danh mục:<span> {props.category_name}</span>
                    <h4>
                        <NavLink to={`/questions/${props.id}`}>{props.title}</NavLink>
                    </h4>
                    <p>{props.content}</p>
                    <div>
                        <i class="fas fa-thumbs-up" id={reactquestion.find(value => value.username === user.email) === undefined ? "dislike-button" : "like-button"} onClick={()=>handleLike()}></i>
                        <span><i class="fas fa-comment-alt"></i>{props.AnswerCount} Câu trả lời</span>
                        <span>{likeNumber[0].like_number} Like</span>
                    </div>
                </div>
            </div>
        )
    }
}
// câu hỏi có kèm theo câu trả lời khi chưa đăng nhập
export function APIQuestion({match}){
    // lấy dữ liệu ứng với question
    // get/question/id
    // thêm câu trả lời thì sẽ làm thay đổi biến answer trong useEffect
    var [QuestionBindAnswer, setQuestionBindAnswer] = useState([]);
    var [QuestionCountAnswer, setQuestionCountAnswer] = useState([]);

    async function getQuestionBindAnswer(id) {
        try{
            const response = await fetch(`http://localhost:8000/question/${id}`);
            const json = await response.json();
            setQuestionBindAnswer(json);
          }
          catch{
            console.log("Lỗi getQuestionBindAnswer");
        }
    }

    async function getQuestionCountAnswer(id) {
        try{
            const response = await fetch(`http://localhost:8000/questions/${id}`);
            const json = await response.json();
            setQuestionCountAnswer(json);
          }
          catch{
            console.log("Lỗi getQuestionCountAnswer");
            console.log(api_url);
        }
    }

    useEffect(() => {
        getQuestionBindAnswer(match.params.id);
        getQuestionCountAnswer(match.params.id);
    }, [match.params.id]);

    if(QuestionCountAnswer.length >= 1)
    {
        return(
            <div>
                <div className="question">
                    <i id="home-icon" class="fas fa-home"></i>
                    <span>
                        <NavLink to={`/`}> Trang chủ </NavLink>
                        / 
                        <NavLink to={`/questions`}> Câu hỏi </NavLink>
                        / {match.params.id}
                    </span>
                </div>
                <DependentQuestion props={QuestionCountAnswer[0]} />
                <div className="question" id="number-question">{QuestionBindAnswer.length} Câu trả lời</div>
                {
                    QuestionBindAnswer.map(item => <Answer answer_id={item.answer_id} key={item.answer_id}/>)
                }
            </div>
        )
    }
    else{
        return(
            <div>blabla</div>
        )
    }
}
// câu hỏi có kèm theo câu trả lời khi đã đăng nhập
export function APIQuestionSignIn({match}){
    // lấy dữ liệu ứng với question
    // get/question/id
    // thêm câu trả lời thì sẽ làm thay đổi biến update trong useEffect
    const { user, isAuthenticated, isLoading } = useAuth0();
    var [QuestionBindAnswer, setQuestionBindAnswer] = useState([]);
    var [QuestionCountAnswer, setQuestionCountAnswer] = useState([]);
    //var update="";
    //var [data, setData] = useState({});

    async function createAnswer(data) {
        try{
            await fetch(`http://localhost:8000/answer`, {
            method: 'POST', // *GET, POST, PUT, DELETE, etc.
            mode: 'cors', // no-cors, *cors, same-origin
            cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
            credentials: 'same-origin', // include, *same-origin, omit
            headers: {
              'Content-Type': 'application/json'
              // 'Content-Type': 'application/x-www-form-urlencoded',
            },
            redirect: 'follow', // manual, *follow, error
            referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
            body: JSON.stringify(data) // body data type must match "Content-Type" header
            });
        }
          catch{
            console.log("Lỗi createAnswer");
        }
    }

    async function getQuestionBindAnswer(id) {
        try{
            const response = await fetch(`http://localhost:8000/question/${id}`);
            const json = await response.json();
            setQuestionBindAnswer(json);
          }
          catch{
            console.log("Lỗi getQuestionBindAnswer");
        }
    }

    async function getQuestionCountAnswer(id) {
        try{
            const response = await fetch(`http://localhost:8000/questions/${id}`);
            const json = await response.json();
            setQuestionCountAnswer(json);
          }
          catch{
            console.log("Lỗi getQuestionCountAnswer");
        }
    }

    const AddAnswer = () => {
        if(document.getElementById('answer').value == "") {
            window.alert('Vui lòng nhập đầy đủ thông tin');
            return;
        }
        var nowDate = new Date();
        var data = {};
        var contentAnswer   = document.getElementById('answer').value;
        data.full_content   = contentAnswer;
        data.status         = 0;
        data.image_link     = "";
        data.question_id    = match.params.id;
        data.username       = user.email;
        data.created_at     = nowDate.getFullYear() + '-' + (nowDate.getMonth() + 1) + '-' + nowDate.getDate();
        createAnswer(data);
        //setData(data);
        window.alert('Bạn đã thêm câu trả lời thành công. Hãy chờ admin duyệt câu trả lời của bạn.');
    }

    useEffect(async () => {
/*         if(Object.keys(data).length !== 0 ) {
            await createAnswer(data);                     // thêm answer bằng post
        } */
        getQuestionBindAnswer(match.params.id);     
        getQuestionCountAnswer(match.params.id);
    }, [match.params.id]);

    useEffect(() => {
        return function cleanup() {
            console.log("component will unmount");
        }
    },[]); 

    if(QuestionCountAnswer.length >= 1)
    {
        return(
            <div>
                <div className="question">
                    <i id="home-icon" class="fas fa-home"></i>
                    <span>
                        <NavLink to={`/`}> Trang chủ </NavLink>
                        / 
                        <NavLink to={`/questions`}> Câu hỏi </NavLink>
                        / {match.params.id}
                    </span>
                </div>
                <DependentQuestion props={QuestionCountAnswer[0]} />
                <div className="question" id="number-question">{QuestionBindAnswer.length} Câu trả lời</div>
                {
                    QuestionBindAnswer.map(item => <Answer answer_id={item.answer_id} key={item.answer_id}/>)
                }
                <div className='question' id="typing-anwser">
                   <form>
                        <label>Nhập câu trả lời</label>
                        <br></br>
                        <textarea id="answer" name="answer" rows="4" cols="120"></textarea>
                        <div>
                            <label for="file">Chọn file:</label>
                            <input  style={{padding: "3px"}} type="file" class="form-control" id="file" accept="" multiple />
                            </div>
                   </form>
                </div>
                <div className='question' id="auto-height">
                    <button id="leave-answer" onClick={AddAnswer}>Thêm câu trả lời</button>
                </div>
            </div>
        )
    }
    else{
        return(
            <div></div>
        )
    }
}

export function Answer({answer_id}){
    var [answer, setAnswer] = useState([]);

    async function getAnswer(id) {
        try{
            const response = await fetch(`http://localhost:8000/answer/${id}`);
            const json = await response.json();
            setAnswer(json);
          }
          catch{
            console.log("Lỗi getAnswer");
        }
    }

    useEffect(() => {
        getAnswer(answer_id);
    }, []);

    return(
        <div className="question">
            <div>
                <i class="far fa-user"></i>
            </div>
            {
                answer.map(item => {
                    return(
                        <div className="question-content" key={item.id}>
                            <span>{item.username}</span>
                            Ngày tạo:<span> {item.created_at}</span>
                            <p>{item.full_content}</p>
                        </div>
                    )
                })    
            }
        </div>
    )
}
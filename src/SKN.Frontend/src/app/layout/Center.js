import { Switch, Route, NavLink } from "react-router-dom";
import "../../app/styles/Center-wrapper.css";
import { useState, useEffect } from "react";
import { userStore, useStore } from "../stores/store";
import Home from "../../features/Home/HomeComp.js";
import Questions, {
  APIQuestion,
  APIQuestionSignIn,
} from "../../features/Questions/QuestionComp.js";
import Users from "../../features/User/UserComp.js";
import Badges from "../../features/Badge/BadgeComp.js";
import { useAuth0 } from "@auth0/auth0-react";
import Verify from "../../features/Verify/VerifyComp.js";
import { DataContext } from "./App.js";
import { useContext } from "react";
import SensitiveWords from "../../features/Questions/blacklist.json";

export default function Center() {
  const { isAuthenticated, user } = useAuth0();
  const { userStore } = useStore();
  const { getCurrentUser } = userStore;
  const [isAuthen, setIsAuthen] = useState(false);
  const [info, setInfo] = useState();
  useEffect(() => {
    const getInfoUser = async () => {
      if (isAuthenticated) {
        await setInfo(await getCurrentUser(user.email));
      }
    };
    getInfoUser();
  }, [isAuthen]);

  if (isAuthenticated ^ isAuthen) {
    setIsAuthen(true);
  }

  return (
    <div className="center-wrapper">
      <Switch>
        <Route path="/" exact={true} component={Home} />
        <Route path="/questions" exact component={Questions} />
        {isAuthenticated ? (
          <Route path="/questions/:id" component={APIQuestionSignIn} />
        ) : (
          <Route path="/questions/:id" component={APIQuestion} />
        )}
        <Route path="/badges" component={Badges} />
        <Route path="/user/:username" component={Users} />
        <Route path="/create-question" component={CreateQuestion} />
        {isAuthenticated ? (
          <Route path="/sign-in" component={Home} />
        ) : (
          <Route path="/sign-in" component={Signin} />
        )}
        <Route path="/sign-up" component={Signup} />
        {isAuthenticated&&user.email== '1712647@student.hcmus.edu' ? (
        <Route path="/verify" component={Verify} />
        ) : (
          <div></div>
        )}
      </Switch>
    </div>
  );
}

export function Signin(props) {
  const style = { width: "90%", margin: "auto" };

  return (
    <div className="sign">
      {/* <form action="" style={style}>
            <span id="recommend">Đăng nhập để có thể tạo câu hỏi</span>
                <div class="form-group">
                    <label for="email">Username or email</label><span className="require">*</span>
                    <input type="email" class="form-control" id="email"/>
                    <i class="fas fa-user"></i>
                </div>
                <div class="form-group">
                    <label for="pwd">Password</label><span className="require">*</span>
                    <input type="password" class="form-control" id="pwd"/>
                    <i class="fas fa-key"></i>
                </div>
                <div class="form-group form-check">
                    <label class="form-check-label">
                    <input class="form-check-input" type="checkbox"/> Remember me!
                    </label>
                </div>
                <button class="btn btn-primary" >Log-in</button>
                <NavLink to = '/sign-up'>
                    <button class="btn btn-primary">Sign-up</button>
                </NavLink>
            </form> */}
      <span id="recommend">Đăng nhập để có thể tạo câu hỏi</span>
    </div>
  );
}
export function Signup(props) {
  const style = { width: "90%", margin: "auto" };
  return (
    <div className="sign">
      <form action="" style={style}>
        <div class="form-group">
          <label for="email">Username</label>
          <span className="require">*</span>
          <input type="text" class="form-control" id="email" />
          <i class="fas fa-user"></i>
        </div>
        <div class="form-group">
          <label for="email">E-Mail</label>
          <span className="require">*</span>
          <input type="email" class="form-control" id="email" />
          <i class="fas fa-envelope"></i>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <span className="require">*</span>
          <input type="text" class="form-control" id="password" />
          <i class="fas fa-key"></i>
        </div>
        <div class="form-group">
          <label for="confirm">Confirm Password</label>
          <span className="require">*</span>
          <input type="text" class="form-control" id="confirm" />
          <i class="fas fa-lock"></i>
        </div>
        <button type="submit" class="btn btn-primary">
          Sign up
        </button>
      </form>
    </div>
  );
}


export function CreateQuestion(props) {
  const style1 = { width: "90%", margin: "auto" };
  const style2 = { marginLeft: "20px" };
  var [category, setCategory] = useState([{ category_name: "Tất cả" }]);
  var [maxid, setMaxId] = useState();
  const { user } = useAuth0();

  async function createQuestion(data) {
    try {
      await fetch("http://localhost:8000/question", {
        method: "POST", // *GET, POST, PUT, DELETE, etc.
        mode: "cors", // no-cors, *cors, same-origin
        cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
        credentials: "same-origin", // include, *same-origin, omit
        headers: {
          "Content-Type": "application/json",
          // 'Content-Type': 'application/x-www-form-urlencoded',
        },
        redirect: "follow", // manual, *follow, error
        referrerPolicy: "no-referrer", // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
        body: JSON.stringify(data), // body data type must match "Content-Type" header
      });
    } catch {
      console.log("Lỗi createQuestion");
    }
  }

  async function createCategoryQuestion(data) {
    try {
      await fetch("http://localhost:8000/categoryquestion", {
        method: "POST", // *GET, POST, PUT, DELETE, etc.
        mode: "cors", // no-cors, *cors, same-origin
        cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
        credentials: "same-origin", // include, *same-origin, omit
        headers: {
          "Content-Type": "application/json",
          // 'Content-Type': 'application/x-www-form-urlencoded',
        },
        redirect: "follow", // manual, *follow, error
        referrerPolicy: "no-referrer", // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
        body: JSON.stringify(data), // body data type must match "Content-Type" header
      });
    } catch {
      console.log("Lỗi createCategoryQuestion");
    }
  }

  async function getMaxId() {
    try {
      const response = await fetch("http://localhost:8000/maxidquestion");
      const json = await response.json();
      setMaxId(json);
    } catch {
      console.log("Lỗi getMaxId");
    }
  }

  async function getCategory() {
    try {
      const response = await fetch("http://localhost:8000/category");
      const json = await response.json();
      setCategory(json);
    } catch {
      console.log("Lỗi getCategory");
    }
  }

  const { settingStore } = useStore();
  const { getSetting } = settingStore;

  async function AddQuestion(e) {
    e.preventDefault();

    const title1 = document.getElementById("title").value;
    const content1 = document.getElementById("content").value;
    if (
      title1 === "" || content1 === ""
      ) {
        window.alert("Vui lòng nhập đầy đủ thông tin");
        return;
      }
    const isAutoVerify = (await getSetting("AutoVerify")).setting_value === "True";
    console.log("gn",isAutoVerify);
    var nowDate = new Date();
    var data1 = {};
    var data2 = {};
    let status1 = 0;
    if (isAutoVerify) 
    {
      status1 = 1;
      sensitive: for (var word in SensitiveWords) {
        if (title1.includes(word) || content1.includes(word)) 
        {
          if (SensitiveWords[word].pos === undefined) 
          {
            for (var pos in SensitiveWords[word].pos) 
            {
              if (!title1.includes(pos) || !content1.includes(pos)) 
              {
                status1 = 0;
                break sensitive;
              }
            }
          }
          else {
            status1 = 0;
            break;
          }
        } 
      }
    }

    data1.title = title1;
    data1.content = content1;
    data1.status = status1;
    data1.username = user.email;
    data1.created_at =
      nowDate.getFullYear() +
      "-" +
      (nowDate.getMonth() + 1) +
      "-" +
      nowDate.getDate();

    data2.category_id = document.getElementById("category").value;
    data2.question_id = maxid[0].MaxId;
    await createQuestion(data1);
    await createCategoryQuestion(data2);
    window.alert(
      "Bạn đã thêm câu hỏi thành công. Hãy chờ admin duyệt câu hỏi của bạn."
    );
  }

  useEffect(() => {
    getCategory();
    getMaxId();
  }, []);

  return (
    <div>
      <form action="" style={style1}>
        <div class="form-group">
          <label for="title">Tiêu đề</label>
          <span className="require">*</span>
          <input type="text" class="form-control" id="title" />
        </div>
        <div class="form-group">
          <label for="content">Nội dung</label>
          <span className="require">*</span>
          <textarea type="email" class="form-control" id="content" rows="20" />
        </div>
        <label for="category">Danh mục: </label>
        <select id="category" name="category" style={style2}>
          {category.map((item, index) => (
            <option value={index + 1} key={index}>
              {item.category_name}
            </option>
          ))}
        </select>
        <button
          style={{ display: "block", marginLeft: "350px" }}
          type="submit"
          class="btn btn-primary"
          onClick={(e)=>AddQuestion(e)}
        >
          Thêm câu hỏi
        </button>
      </form>
    </div>
  );
}

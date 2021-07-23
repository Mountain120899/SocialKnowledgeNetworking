import {NavLink} from "react-router-dom";


import "../../app/styles/Left-menu.css"

export default function LeftMenuComp(){
    return(
        <div className="left-menu">
            <ul>
                <NavLink to = '/' activeStyle={{color: "red"}} exact={true}> 
                    <li>Trang chủ </li>
                </NavLink>
                <NavLink to = '/questions' activeStyle={{color: "red"}}>
                    <li>Danh mục câu hỏi</li>
                </NavLink>
                <NavLink to = '/badges' activeStyle={{color: "red"}}>
                    <li>Danh hiệu</li>
                </NavLink>
                <NavLink to = '/communities' activeStyle={{color: "red"}}>
                </NavLink>
                <NavLink to = '/user' activeStyle={{color: "red"}}>
                    <li>Người dùng</li>
                </NavLink>
            </ul>
        </div>
    )
}
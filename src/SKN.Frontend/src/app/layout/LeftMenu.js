import { NavLink } from "react-router-dom";
import { useAuth0 } from "@auth0/auth0-react";

import "../../app/styles/Left-menu.css";

export default function LeftMenuComp() {
  const { isAuthenticated, user } = useAuth0();

  return (
    <div className="left-menu">
      <ul>
        <NavLink to="/" activeStyle={{ color: "red" }} exact={true}>
          <li>Trang chủ </li>
        </NavLink>
        <NavLink to="/questions" activeStyle={{ color: "red" }}>
          <li>Danh mục câu hỏi</li>
        </NavLink>
        <NavLink to="/badges" activeStyle={{ color: "red" }}>
          <li>Danh hiệu</li>
        </NavLink>
        <NavLink to="/communities" activeStyle={{ color: "red" }}></NavLink>
        {isAuthenticated ? (
          <NavLink to={"/user/" + user.email} activeStyle={{ color: "red" }}>
            <li>Người dùng</li>
          </NavLink>
        ) : (
          <></>
        )}
        {isAuthenticated &&
          (user.email == '1712647@student.hcmus.edu' ? (
            <NavLink to="/verify" activeStyle={{ color: "red" }}>
              <li>Kiểm duyệt</li>
            </NavLink>
          ) : (
            <></>
          ))}
      </ul>
    </div>
  );
}

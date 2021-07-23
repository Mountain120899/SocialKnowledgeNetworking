
import React from 'react';
import {BrowserRouter as Router, Link} from "react-router-dom";

import '../styles/App.css';

import Header from './Header.js';
import FooterComp from './Footer.js';
import LeftMenuComp from './LeftMenu.js';
import Center from './Center.js';
import RightMenuComp from './RightMenu.js';
import { useAuth0 } from "@auth0/auth0-react";

function App() {
  const { user, isAuthenticated, isLoading } = useAuth0();
  // xử lý thanh cuộn
  window.onscroll = function() {myFunction()};
  function myFunction() {
    if (document.body.scrollTop > 150 || document.documentElement.scrollTop > 150) {
      document.getElementById("scroll-up").style.display = "inline";
    }
    else{
      document.getElementById("scroll-up").style.display = "none";
    }
  }

  return (
    <Router>
      <div className="App">
          <Header  />
        <div className="wrapper" id="scrollTop">
          <LeftMenuComp />
          <div className="content-wrapper">
              <Center />
            <RightMenuComp />
          </div>
        </div>
        {
          isAuthenticated ? <Link to = 'create-question' id = "buttoncreate">
            <i class="fas fa-pen"></i> </Link>  : <span></span>
        }
        <a href="#scrollTop" id="scroll-up"><i class="fas fa-arrow-up"></i></a>  
        <FooterComp />
      </div>
    </Router>
  );
}

export default App;

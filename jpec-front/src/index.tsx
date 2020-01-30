import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import * as serviceWorker from './serviceWorker';
import './css/fontawesome-all.min.css'
import './css/main.css'

import {
  BrowserRouter as Router,
  Switch,
  Route,
  Link
} from "react-router-dom";
import FirstPage from './pages/HomePage/FirstPage';
import SecondPage from './pages/SecondPage';
import MathPage from './pages/Math/MathPage';

export default function App() {
    return (
      <Router>
        {/* <div>
          <nav>
            <ul>
              <li>
                <Link to="/">Home</Link>
              </li>
              <li>
                <Link to="/japanese">Japanese</Link>
              </li>
              <li>
                <Link to="/math">Math</Link>
              </li>
            </ul>
          </nav>
        </div> */}
<section id="header">
					<div className="container">

							<h1 id="logo"><a href="index.html">Strongly Typed</a></h1>
							<p>A responsive HTML5 site template. Manufactured by HTML5 UP.</p>
							<nav id="nav">
								<ul>
									<li><a className="icon solid fa-home" href="index.html"><span>Introduction</span></a></li>
									<li>
										<a href="#" className="icon fa-chart-bar"><span>Dropdown</span></a>
										<ul>
											<li><a href="#">Lorem ipsum dolor</a></li>
											<li><a href="#">Magna phasellus</a></li>
											<li><a href="#">Etiam dolore nisl</a></li>
											<li>
												<a href="#">Phasellus consequat</a>
												<ul>
													<li><a href="#">Magna phasellus</a></li>
													<li><a href="#">Etiam dolore nisl</a></li>
													<li><a href="#">Phasellus consequat</a></li>
												</ul>
											</li>
											<li><a href="#">Veroeros feugiat</a></li>
										</ul>
									</li>
									<li><a className="icon solid fa-cog" href="left-sidebar.html"><span>Left Sidebar</span></a></li>
									<li><a className="icon solid fa-retweet" href="right-sidebar.html"><span>Right Sidebar</span></a></li>
									<li><a className="icon solid fa-sitemap" href="no-sidebar.html"><span>No Sidebar</span></a></li>
								</ul>
							</nav>

					</div>
				</section>
        <Switch>
            <Route path="/math">
              <MathPage />
            </Route>
            <Route path="/japanese">
              <SecondPage />
            </Route>
            <Route path="/">
            <FirstPage />
            </Route>
          </Switch>
      </Router>
    );
  }

ReactDOM.render(<App />, document.getElementById('root'));

// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: https://bit.ly/CRA-PWA
serviceWorker.unregister();

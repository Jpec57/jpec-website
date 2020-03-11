import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import './pages/Math/MathPage.scss';
import * as serviceWorker from './serviceWorker';
import './css/fontawesome-all.min.css'
import './css/main.scss'

import {
  BrowserRouter as Router,
  Switch,
  Route,
  Link
} from "react-router-dom";
import FirstPage from './pages/HomePage/FirstPage';
import SecondPage from './pages/Programming/SecondPage';
import MathPage from './pages/Math/MathPage';
import DeepLearningPage from './pages/Math/DeepLeaning/DeepLearning';

const routes = [
  {
    path: "/",
    component: FirstPage
  },
  {
    path: "/japanese",
    component: SecondPage
  },
  {
    path: "/math",
    component: MathPage,
    routes: [
      {
        path: "/math/deep-leaning",
        component: DeepLearningPage
      }
    ]
  }
];


export default function App() {
    return (
      <Router>
<section id="header">
					<div className="container">
							<h1 id="logo"><a href="index.html">Jpec website</a></h1>
							<p>This website is created to learn Rust and show you what I am currently fond of.</p>
							<nav id="nav" className="navbar navbar-default">
								<ul>
									<li>
                  <Link to="/" className="icon solid fa-home">HomePage</Link>
                    </li>
                  <li>
                <Link to="/japanese" className="icon solid fa-globe-asia">Japanese</Link>
              </li>
              <li>
                <Link to="/math" className="icon solid fa-calculator">Maths</Link>
              </li>
								</ul>
							</nav>
					</div>
				</section>
        <Switch>
          {routes.map((route, i) => (
            <RouteWithSubRoutes key={i} {...route} />
          ))}
        </Switch>
        {/* <Switch>

            <Route path="/math">

              <MathPage />
            </Route>
            <Route path="/japanese">
              <SecondPage />
            </Route>

            <Route path="/">
            <FirstPage />
            </Route>
          </Switch> */}
                  {routes.map((route, i) => (
          <RouteWithSubRoutes key={i} {...route} />
        ))}
      </Router>
    );
  }

  function RouteWithSubRoutes(route: any) {
    return (
      <Route
        path={route.path}
        render={props => (
          // pass the sub-routes down to keep nesting
          <route.component {...props} routes={route.routes} />
        )}
      />
    );
  }

ReactDOM.render(<App />, document.getElementById('root'));

// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: https://bit.ly/CRA-PWA
serviceWorker.unregister();

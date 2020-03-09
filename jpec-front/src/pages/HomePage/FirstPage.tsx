import React from 'react';
const FirstPage: React.FC = () => {
  return (
    <div className="container">
      <header className="header-content">
      </header>
      <div>
        <span>This is a test</span>
        <div id="canvas_box" className="canvas-box">
        </div>
        <div id="chart_box" className="chart-box"></div>

        <button id="clear-button" className="btn btn-dark">Clear</button>
        <button id="predict-button" className="btn btn-dark">Predict</button>
      </div>
    </div>
  );
}

export default FirstPage;

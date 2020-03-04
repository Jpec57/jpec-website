import React from 'react';
const Latex = require('react-latex');

const MathPage: React.FC = () => {
  return (
    <div className="App">
      <header className="App-header">
        <p>
          This is a math page
        </p>
        <Latex>What is $(3\times 4) \div (5-3)$</Latex>
      </header>
    </div>
  );
}

export default MathPage;

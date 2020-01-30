import React, { useState } from 'react';

const MathPage: React.FC = () => {
  const [count, setCounter] = useState(0); 

  return (
    <div className="App">
      <header className="App-header">
        <p>
          This is a math page
        </p>
      </header>
    </div>
  );
}

export default MathPage;

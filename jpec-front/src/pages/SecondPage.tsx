import React, { useState } from 'react';

const SecondPage: React.FC = () => {
  const [count, setCounter] = useState(0); 

  return (
    <div className="App">
      <header className="App-header">
        <p>
          This is a second page
        </p>
      </header>
    </div>
  );
}

export default SecondPage;

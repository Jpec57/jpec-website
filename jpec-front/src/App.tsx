import React, { useState } from 'react';
const FirstPage: React.FC = () => {
  const [count, setCounter] = useState(0); 

  // fetch('http://localhost:8000/json')
  // .then(res => res.json())
  // .then((data) => {
  //   console.log(data);
  // })
  // .catch(console.log);

  return (
    <div className="App">
      <header className="App-header">
        <p>
          This is my project: {count}
        </p>
        <button onClick={()=> setCounter(count + 1)}>
          Increment
        </button>
      </header>
    </div>
  );
}

export default FirstPage;

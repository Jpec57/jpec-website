import React, {useRef, MutableRefObject} from 'react';
const JapanesePage: React.FC = () => {
    var speechSynthesisVar: MutableRefObject<SpeechSynthesisUtterance> = useRef(new SpeechSynthesisUtterance());


    const configureSpeechSynthesis = (rate: number = 1): SpeechSynthesisUtterance => {
        const msg = new SpeechSynthesisUtterance();
        msg.voice = window.speechSynthesis.getVoices()
            .filter((voice) => 
                voice.name === 'Kyoko'
                )[0];
        msg.rate = rate;
        return msg;
    };

    // //TODO should only look once at page load but doesn't work
    // useEffect(()=>{
    //     speechSynthesisVar.current = configureSpeechSynthesis();
    // }, []);

    const say = (message: string) => {
        speechSynthesisVar.current = configureSpeechSynthesis();
        speechSynthesisVar.current.text = message;
        window.speechSynthesis.speak(speechSynthesisVar.current);
    };

  return (
    <div className="container">
      <header className="header-content">
      </header>
      <div>
        <span>This is a test</span>
        <button onClick={()=>{
            say('国内外の取材網を生かし、さまざまな分野のニュースをいち早く、正確にお伝えします')
            }}>
            Click here
        </button>
      </div>
    </div>
  );
}

export default JapanesePage;

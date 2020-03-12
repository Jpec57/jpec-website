import React from 'react';
import Card from '../../components/Card/Card';
// const Latex = require('react-latex');

const mathPages = [
  {
    name: "Apprentissage Profond",
    path: "/deep-learning"
  },
  {
    name: "Apprentissage Profond",
    path: "/deep-learning"
  },
  {
    name: "Apprentissage Profond",
    path: "/deep-learning"
  },
  {
    name: "Apprentissage Profond Je suis un text assez long",
    path: "/deep-learning"
  }
];


const MathPage: React.FC = () => {

  return (
    <div className="container">
      <header className="header-content">
      </header>

<div className="grid">
<div className="grid-container">

{mathPages.map((page, index) => {
      return (
        <div className="grid-item"> <Card key={index} name={page.name} path={`/math${page.path}`}/></div>  

       
      );
  })}
  </div>
</div>

    </div>
  );
}

export default MathPage;
/*
Récupérer les données
Nettoyer (consistantes et sans valeur abbérante)
Explorer 
Créer le modèle statistique
Evaluer la qualité du modèle (à représenter)
Déployer l'algorithme (en production)


chaque donnée observée est l'expression d'une variable aléatoire générée par une distribution de probabilité
*/
import React from 'react';
import Card from '../../components/Card/Card';

const mathPages = [
  {
    name: "Apprentissage Profond",
    path: "/deep-learning"
  },
  {
    name: "k-NN",
    path: "/k-nn"
  },
  {
    name: "Régression linéaire",
    path: "/linear-regression"
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
        <div key={index} className="grid-item"> <Card key={index} name={page.name} path={`/math${page.path}`}/></div>  
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
import React from 'react';
import { useWindowSize } from '../../hooks/useWindowSize';
import { Link } from 'react-router-dom';
const Latex = require('react-latex');

const MathPage: React.FC = () => {
  return (
    <div className="container">
      <header className="header-content">
        <p>
          This is a math page
          <Link to="/deep-learning">Deep learning</Link>
        </p>
      </header>
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
import React from 'react';
import ReactDOM from 'react-dom';

import Navbar from './components/Navbar';

import '../scss/app.scss';

// start the Stimulus application
import '../bootstrap';

const App = () => {
    return (
      <Navbar />
    );
};

const rootElement = document.querySelector('#app');
ReactDOM.render(<App />, rootElement);
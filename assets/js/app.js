import React from 'react';
import ReactDOM from 'react-dom';
import Navbar from "./components/Navbar";

import '../scss/app.scss';
import HomePage from "./pages/HomePage";

const App = () => {
    return (
        <>
            <Navbar/>
            <div className="container pt-5">
                <HomePage/>
            </div>
        </>
    );
};

const rootElement = document.querySelector('#app');
ReactDOM.render(<App/>, rootElement);

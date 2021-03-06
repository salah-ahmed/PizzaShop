import React from 'react';
import { NavLink } from 'react-router-dom';

const Nav = (props) => {
    return (
        <nav className="navbar navbar-expand-lg navbar-dark bg-dark">
            <NavLink to="/" className="navbar-brand">Home</NavLink>
            <button className="navbar-toggler" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span className="navbar-toggler-icon"></span>
            </button>

            <div className="collapse navbar-collapse" id="navbarSupportedContent">
                <ul className="navbar-nav mr-auto">
                </ul>
                <ul className="navbar-nav">
                    <li className="nav-item">
                        <NavLink to="/cart" className="nav-link">cart</NavLink>
                    </li>
                    <li className="nav-item">
                        {
                            localStorage.getItem("token") === null ?
                            <NavLink to="/login" className="nav-link">Login</NavLink>
                            : <NavLink to="/profile" className="nav-link">profile</NavLink>
                        }
                    </li>
                </ul>
            </div>
        </nav>
    );
}

export default Nav;
import React from 'react'
import { Link, NavLink, Outlet } from 'react-router-dom';

const SettingsPage = () => {
  return (
    <div>
      <h1>Settings</h1>
      <nav>
        <ul>
          <li><NavLink to="profile">Profile Settings</NavLink></li>
          <li><NavLink to="account">Account Settings</NavLink></li>
        </ul>
      </nav>

      {/* Outlet will render child components based on the current route */}
      <Outlet />
    </div>
  );
}

export default SettingsPage
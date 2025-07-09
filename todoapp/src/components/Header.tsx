import React from 'react';
import { Link, NavLink } from 'react-router-dom';

interface Statistics {
  total: number;
  completed: number;
  pending: number;
  completion_rate: number;
}

interface HeaderProps {
  statistics: Statistics;
}

const Header: React.FC<HeaderProps> = ({ statistics }) => {
  return (
    <header className="header">
      <div className="header-container">
        <Link to="/" className="logo">Todo App</Link>
        
        <div className="stats">
          <div className="stat">
            <div className="stat-value">{statistics.total}</div>
            <div className="stat-label">Total</div>
          </div>
          <div className="stat">
            <div className="stat-value">{statistics.completed}</div>
            <div className="stat-label">Completed</div>
          </div>
          <div className="stat">
            <div className="stat-value">{statistics.pending}</div>
            <div className="stat-label">Pending</div>
          </div>
          <div className="stat">
            <div className="stat-value">{statistics.completion_rate}%</div>
            <div className="stat-label">Completion</div>
          </div>
        </div>
        
        <nav className="nav">
          <NavLink 
            to="/todos"
            className={({ isActive }) => isActive ? 'nav-link active' : 'nav-link'}
          >
            Todos
          </NavLink>
          <NavLink 
            to="/categories"
            className={({ isActive }) => isActive ? 'nav-link active' : 'nav-link'}
          >
            Categories
          </NavLink>
        </nav>
      </div>
    </header>
  );
};

export default Header; 
import React, { useState } from 'react';
import { Link } from 'react-router-dom';

interface Todo {
  id: number;
  title: string;
  description: string;
  status: 'pending' | 'in_progress' | 'completed';
  priority: 'low' | 'medium' | 'high';
  due_date: string;
  category_id: number | null;
  parent_id: number | null;
  created_at: string;
  updated_at: string;
  is_completed: boolean;
  subtasks_count: number;
  completed_subtasks_count: number;
  category?: Category;
}

interface Category {
  id: number;
  name: string;
  color: string;
  created_at: string;
  updated_at: string;
  todos_count: number;
}

interface TodoListProps {
  todos: Todo[];
  categories: Category[];
  onAddTodo: (todo: Omit<Todo, 'id' | 'created_at' | 'updated_at' | 'is_completed' | 'subtasks_count' | 'completed_subtasks_count'>) => void;
  onUpdateTodo: (id: number, updates: Partial<Todo>) => void;
  onDeleteTodo: (id: number) => void;
}

const TodoList: React.FC<TodoListProps> = ({
  todos,
  categories,
  onAddTodo,
  onUpdateTodo,
  onDeleteTodo
}) => {
  const [statusFilter, setStatusFilter] = useState<string>('all');
  const [priorityFilter, setPriorityFilter] = useState<string>('all');
  const [categoryFilter, setCategoryFilter] = useState<string>('all');
  const [showAddForm, setShowAddForm] = useState<boolean>(false);
  const [newTodo, setNewTodo] = useState<Omit<Todo, 'id' | 'created_at' | 'updated_at' | 'is_completed' | 'subtasks_count' | 'completed_subtasks_count'>>({
    title: '',
    description: '',
    status: 'pending',
    priority: 'medium',
    due_date: new Date().toISOString().slice(0, 16),
    category_id: null,
    parent_id: null
  });

  // Filter todos based on selected filters
  const filteredTodos = todos.filter(todo => {
    // Filter by status
    if (statusFilter !== 'all' && todo.status !== statusFilter) {
      return false;
    }
    
    // Filter by priority
    if (priorityFilter !== 'all' && todo.priority !== priorityFilter) {
      return false;
    }
    
    // Filter by category
    if (categoryFilter !== 'all' && todo.category_id !== Number(categoryFilter)) {
      return false;
    }
    
    return true;
  });

  // Handle form input changes
  const handleInputChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement>) => {
    const { name, value } = e.target;
    
    setNewTodo(prev => ({
      ...prev,
      [name]: value
    }));
  };

  // Handle category selection
  const handleCategoryChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
    const value = e.target.value;
    setNewTodo(prev => ({
      ...prev,
      category_id: value === '' ? null : Number(value)
    }));
  };

  // Handle form submission
  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    
    // Validate input
    if (!newTodo.title.trim()) {
      alert('Title is required');
      return;
    }
    
    // Add new todo
    onAddTodo(newTodo);
    
    // Reset form
    setNewTodo({
      title: '',
      description: '',
      status: 'pending',
      priority: 'medium',
      due_date: new Date().toISOString().slice(0, 16),
      category_id: null,
      parent_id: null
    });
    
    // Hide form
    setShowAddForm(false);
  };

  // Toggle todo completion status
  const toggleTodoStatus = (todo: Todo) => {
    const newStatus = todo.status === 'completed' ? 'pending' : 'completed';
    onUpdateTodo(todo.id, { status: newStatus });
  };

  // Format date for display
  const formatDate = (dateString: string) => {
    const date = new Date(dateString);
    return date.toLocaleDateString();
  };

  return (
    <div>
      <div className="card">
        <div className="card-title">Todos</div>
        
        {/* Filters */}
        <div className="filters">
          <div className="filter-group">
            <label className="filter-label">Status:</label>
            <select 
              className="filter-select"
              value={statusFilter}
              onChange={(e) => setStatusFilter(e.target.value)}
            >
              <option value="all">All</option>
              <option value="pending">Pending</option>
              <option value="in_progress">In Progress</option>
              <option value="completed">Completed</option>
            </select>
          </div>
          
          <div className="filter-group">
            <label className="filter-label">Priority:</label>
            <select 
              className="filter-select"
              value={priorityFilter}
              onChange={(e) => setPriorityFilter(e.target.value)}
            >
              <option value="all">All</option>
              <option value="low">Low</option>
              <option value="medium">Medium</option>
              <option value="high">High</option>
            </select>
          </div>
          
          <div className="filter-group">
            <label className="filter-label">Category:</label>
            <select 
              className="filter-select"
              value={categoryFilter}
              onChange={(e) => setCategoryFilter(e.target.value)}
            >
              <option value="all">All</option>
              {categories.map(category => (
                <option key={category.id} value={category.id}>{category.name}</option>
              ))}
            </select>
          </div>
          
          <button 
            className="btn btn-primary"
            onClick={() => setShowAddForm(!showAddForm)}
          >
            {showAddForm ? 'Cancel' : 'Add Todo'}
          </button>
        </div>
        
        {/* Add Todo Form */}
        {showAddForm && (
          <div className="card">
            <h3 className="card-title">Add New Todo</h3>
            <form onSubmit={handleSubmit}>
              <div className="form-group">
                <label className="form-label">Title</label>
                <input 
                  type="text"
                  className="form-input"
                  name="title"
                  value={newTodo.title}
                  onChange={handleInputChange}
                  required
                />
              </div>
              
              <div className="form-group">
                <label className="form-label">Description</label>
                <textarea 
                  className="form-textarea"
                  name="description"
                  value={newTodo.description}
                  onChange={handleInputChange}
                />
              </div>
              
              <div className="form-group">
                <label className="form-label">Status</label>
                <select 
                  className="form-select"
                  name="status"
                  value={newTodo.status}
                  onChange={handleInputChange}
                >
                  <option value="pending">Pending</option>
                  <option value="in_progress">In Progress</option>
                  <option value="completed">Completed</option>
                </select>
              </div>
              
              <div className="form-group">
                <label className="form-label">Priority</label>
                <select 
                  className="form-select"
                  name="priority"
                  value={newTodo.priority}
                  onChange={handleInputChange}
                >
                  <option value="low">Low</option>
                  <option value="medium">Medium</option>
                  <option value="high">High</option>
                </select>
              </div>
              
              <div className="form-group">
                <label className="form-label">Due Date</label>
                <input 
                  type="datetime-local"
                  className="form-input"
                  name="due_date"
                  value={newTodo.due_date}
                  onChange={handleInputChange}
                  required
                />
              </div>
              
              <div className="form-group">
                <label className="form-label">Category</label>
                <select 
                  className="form-select"
                  value={newTodo.category_id || ''}
                  onChange={handleCategoryChange}
                >
                  <option value="">None</option>
                  {categories.map(category => (
                    <option key={category.id} value={category.id}>{category.name}</option>
                  ))}
                </select>
              </div>
              
              <button type="submit" className="btn btn-primary">
                Add Todo
              </button>
            </form>
          </div>
        )}
        
        {/* Todo List */}
        {filteredTodos.length > 0 ? (
          <div className="todo-list">
            {filteredTodos.map(todo => (
              <div 
                key={todo.id} 
                className={`todo-item ${todo.is_completed ? 'todo-completed' : ''}`}
              >
                <input 
                  type="checkbox"
                  className="todo-checkbox"
                  checked={todo.is_completed}
                  onChange={() => toggleTodoStatus(todo)}
                />
                
                <div className="todo-content">
                  <Link to={`/todos/${todo.id}`} className="todo-title">
                    {todo.title}
                  </Link>
                  
                  <div className="todo-details">
                    <span className="todo-priority">
                      {todo.priority.charAt(0).toUpperCase() + todo.priority.slice(1)}
                    </span>
                    
                    {todo.category && (
                      <span 
                        className="todo-category"
                        style={{ backgroundColor: todo.category.color }}
                      >
                        {todo.category.name}
                      </span>
                    )}
                    
                    <span className="todo-due-date">
                      Due: {formatDate(todo.due_date)}
                    </span>
                    
                    {todo.subtasks_count > 0 && (
                      <span className="todo-subtasks">
                        Subtasks: {todo.completed_subtasks_count}/{todo.subtasks_count}
                      </span>
                    )}
                  </div>
                </div>
                
                <div className="todo-actions">
                  <button 
                    className="btn btn-sm btn-outline"
                    onClick={() => onDeleteTodo(todo.id)}
                    title="Delete"
                  >
                    Delete
                  </button>
                </div>
              </div>
            ))}
          </div>
        ) : (
          <div className="empty-state">
            <p>No todos match your filters</p>
          </div>
        )}
      </div>
    </div>
  );
};

export default TodoList; 
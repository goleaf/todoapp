import React, { useState, useEffect } from 'react';
import { useParams, useNavigate, Link } from 'react-router-dom';

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

interface TodoDetailProps {
  todos: Todo[];
  categories: Category[];
  onUpdateTodo: (id: number, updates: Partial<Todo>) => void;
  onDeleteTodo: (id: number) => void;
}

const TodoDetail: React.FC<TodoDetailProps> = ({
  todos,
  categories,
  onUpdateTodo,
  onDeleteTodo
}) => {
  const { id } = useParams<{ id: string }>();
  const navigate = useNavigate();
  const todoId = Number(id);
  
  const [todo, setTodo] = useState<Todo | null>(null);
  const [isEditing, setIsEditing] = useState(false);
  const [editedTodo, setEditedTodo] = useState<Partial<Todo>>({});
  const [subtasks, setSubtasks] = useState<Todo[]>([]);
  
  // Find the todo and its subtasks when component mounts or id changes
  useEffect(() => {
    const currentTodo = todos.find(t => t.id === todoId);
    if (currentTodo) {
      setTodo(currentTodo);
      
      // Find subtasks
      const todoSubtasks = todos.filter(t => t.parent_id === todoId);
      setSubtasks(todoSubtasks);
      
      // Initialize edited todo
      setEditedTodo({
        title: currentTodo.title,
        description: currentTodo.description,
        status: currentTodo.status,
        priority: currentTodo.priority,
        due_date: currentTodo.due_date,
        category_id: currentTodo.category_id
      });
    } else {
      // Todo not found, navigate back to list
      navigate('/todos');
    }
  }, [todos, todoId, navigate]);
  
  // Handle form input changes
  const handleInputChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement>) => {
    const { name, value } = e.target;
    
    setEditedTodo(prev => ({
      ...prev,
      [name]: value
    }));
  };
  
  // Handle category selection
  const handleCategoryChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
    const value = e.target.value;
    setEditedTodo(prev => ({
      ...prev,
      category_id: value === '' ? null : Number(value)
    }));
  };
  
  // Handle form submission
  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    
    if (todo) {
      onUpdateTodo(todo.id, editedTodo);
      setIsEditing(false);
    }
  };
  
  // Handle delete confirmation
  const handleDelete = () => {
    if (window.confirm('Are you sure you want to delete this todo?')) {
      onDeleteTodo(todoId);
      navigate('/todos');
    }
  };
  
  // Format date for display
  const formatDate = (dateString: string) => {
    const date = new Date(dateString);
    return date.toLocaleDateString();
  };
  
  // Format date for datetime-local input
  const formatDateForInput = (dateString: string) => {
    const date = new Date(dateString);
    return date.toISOString().slice(0, 16);
  };
  
  if (!todo) {
    return <div className="loading">Loading...</div>;
  }
  
  return (
    <div>
      <div className="card">
        {isEditing ? (
          <>
            <div className="card-title">Edit Todo</div>
            <form onSubmit={handleSubmit}>
              <div className="form-group">
                <label className="form-label">Title</label>
                <input 
                  type="text"
                  className="form-input"
                  name="title"
                  value={editedTodo.title || ''}
                  onChange={handleInputChange}
                  required
                />
              </div>
              
              <div className="form-group">
                <label className="form-label">Description</label>
                <textarea 
                  className="form-textarea"
                  name="description"
                  value={editedTodo.description || ''}
                  onChange={handleInputChange}
                />
              </div>
              
              <div className="form-group">
                <label className="form-label">Status</label>
                <select 
                  className="form-select"
                  name="status"
                  value={editedTodo.status || ''}
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
                  value={editedTodo.priority || ''}
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
                  value={formatDateForInput(editedTodo.due_date || todo.due_date)}
                  onChange={handleInputChange}
                  required
                />
              </div>
              
              <div className="form-group">
                <label className="form-label">Category</label>
                <select 
                  className="form-select"
                  value={editedTodo.category_id || ''}
                  onChange={handleCategoryChange}
                >
                  <option value="">None</option>
                  {categories.map(category => (
                    <option key={category.id} value={category.id}>{category.name}</option>
                  ))}
                </select>
              </div>
              
              <div className="form-actions">
                <button type="submit" className="btn btn-primary">
                  Save Changes
                </button>
                <button 
                  type="button" 
                  className="btn btn-outline"
                  onClick={() => setIsEditing(false)}
                >
                  Cancel
                </button>
              </div>
            </form>
          </>
        ) : (
          <>
            <div className="detail-header">
              <h2 className="card-title">{todo.title}</h2>
              <div className="detail-actions">
                <button 
                  className="btn btn-outline"
                  onClick={() => setIsEditing(true)}
                >
                  Edit
                </button>
                <button 
                  className="btn btn-danger"
                  onClick={handleDelete}
                >
                  Delete
                </button>
              </div>
            </div>
            
            <div className="detail-content">
              <div className="detail-section">
                <div className="detail-label">Status:</div>
                <div className="detail-value">
                  {todo.status.charAt(0).toUpperCase() + todo.status.slice(1)}
                </div>
              </div>
              
              <div className="detail-section">
                <div className="detail-label">Priority:</div>
                <div className="detail-value">
                  {todo.priority.charAt(0).toUpperCase() + todo.priority.slice(1)}
                </div>
              </div>
              
              <div className="detail-section">
                <div className="detail-label">Due Date:</div>
                <div className="detail-value">{formatDate(todo.due_date)}</div>
              </div>
              
              <div className="detail-section">
                <div className="detail-label">Category:</div>
                <div className="detail-value">
                  {todo.category ? (
                    <span 
                      className="todo-category"
                      style={{ backgroundColor: todo.category.color }}
                    >
                      {todo.category.name}
                    </span>
                  ) : 'None'}
                </div>
              </div>
              
              <div className="detail-section">
                <div className="detail-label">Description:</div>
                <div className="detail-value">{todo.description || 'No description provided'}</div>
              </div>
              
              <div className="detail-section">
                <div className="detail-label">Created:</div>
                <div className="detail-value">{formatDate(todo.created_at)}</div>
              </div>
              
              <div className="detail-section">
                <div className="detail-label">Last Updated:</div>
                <div className="detail-value">{formatDate(todo.updated_at)}</div>
              </div>
            </div>
          </>
        )}
      </div>
      
      {/* Subtasks */}
      <div className="card">
        <div className="card-title">Subtasks</div>
        
        {subtasks.length > 0 ? (
          <div className="todo-list">
            {subtasks.map(subtask => (
              <div 
                key={subtask.id} 
                className={`todo-item ${subtask.is_completed ? 'todo-completed' : ''}`}
              >
                <input 
                  type="checkbox"
                  className="todo-checkbox"
                  checked={subtask.is_completed}
                  onChange={() => {
                    const newStatus = subtask.status === 'completed' ? 'pending' : 'completed';
                    onUpdateTodo(subtask.id, { status: newStatus });
                  }}
                />
                
                <div className="todo-content">
                  <Link to={`/todos/${subtask.id}`} className="todo-title">
                    {subtask.title}
                  </Link>
                  
                  <div className="todo-details">
                    <span className="todo-priority">
                      {subtask.priority.charAt(0).toUpperCase() + subtask.priority.slice(1)}
                    </span>
                    
                    <span className="todo-due-date">
                      Due: {formatDate(subtask.due_date)}
                    </span>
                  </div>
                </div>
                
                <div className="todo-actions">
                  <button 
                    className="btn btn-sm btn-outline"
                    onClick={() => onDeleteTodo(subtask.id)}
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
            <p>No subtasks for this todo</p>
          </div>
        )}
        
        <div className="subtask-actions">
          <Link to={`/todos?parent=${todo.id}`} className="btn btn-primary">
            Add Subtask
          </Link>
        </div>
      </div>
      
      <div className="navigation-actions">
        <Link to="/todos" className="btn btn-outline">
          Back to Todos
        </Link>
      </div>
    </div>
  );
};

export default TodoDetail; 
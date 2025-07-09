import React, { useState, useEffect } from 'react';
import { BrowserRouter as Router, Routes, Route, Navigate } from 'react-router-dom';
import './App.css';

// Pages
import TodoList from './pages/TodoList';
import TodoDetail from './pages/TodoDetail';
import CategoryList from './pages/CategoryList';
import Header from './components/Header';

// Types
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

interface Statistics {
  total: number;
  completed: number;
  pending: number;
  completion_rate: number;
}

function App() {
  const [todos, setTodos] = useState<Todo[]>([]);
  const [categories, setCategories] = useState<Category[]>([]);
  const [statistics, setStatistics] = useState<Statistics>({
    total: 0,
    completed: 0,
    pending: 0,
    completion_rate: 0
  });
  const [loading, setLoading] = useState<boolean>(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    // This would normally fetch data from the API
    // For now, we'll use mock data
    const mockTodos: Todo[] = [
      {
        id: 1,
        title: "Complete project",
        description: "Finish the TodoApp project",
        status: "in_progress",
        priority: "high",
        due_date: "2023-06-30T00:00:00.000000Z",
        category_id: 1,
        parent_id: null,
        created_at: "2023-06-01T00:00:00.000000Z",
        updated_at: "2023-06-01T00:00:00.000000Z",
        is_completed: false,
        subtasks_count: 2,
        completed_subtasks_count: 1,
        category: {
          id: 1,
          name: "Work",
          color: "#4F46E5",
          created_at: "2023-06-01T00:00:00.000000Z",
          updated_at: "2023-06-01T00:00:00.000000Z",
          todos_count: 3
        }
      },
      {
        id: 2,
        title: "Buy groceries",
        description: "Get items for dinner",
        status: "pending",
        priority: "medium",
        due_date: "2023-06-25T00:00:00.000000Z",
        category_id: 2,
        parent_id: null,
        created_at: "2023-06-01T00:00:00.000000Z",
        updated_at: "2023-06-01T00:00:00.000000Z",
        is_completed: false,
        subtasks_count: 0,
        completed_subtasks_count: 0,
        category: {
          id: 2,
          name: "Personal",
          color: "#10B981",
          created_at: "2023-06-01T00:00:00.000000Z",
          updated_at: "2023-06-01T00:00:00.000000Z",
          todos_count: 2
        }
      },
      {
        id: 3,
        title: "Call mom",
        description: "Weekly call with mom",
        status: "completed",
        priority: "medium",
        due_date: "2023-06-20T00:00:00.000000Z",
        category_id: 2,
        parent_id: null,
        created_at: "2023-06-01T00:00:00.000000Z",
        updated_at: "2023-06-21T00:00:00.000000Z",
        is_completed: true,
        subtasks_count: 0,
        completed_subtasks_count: 0,
        category: {
          id: 2,
          name: "Personal",
          color: "#10B981",
          created_at: "2023-06-01T00:00:00.000000Z",
          updated_at: "2023-06-01T00:00:00.000000Z",
          todos_count: 2
        }
      }
    ];

    const mockCategories: Category[] = [
      {
        id: 1,
        name: "Work",
        color: "#4F46E5",
        created_at: "2023-06-01T00:00:00.000000Z",
        updated_at: "2023-06-01T00:00:00.000000Z",
        todos_count: 3
      },
      {
        id: 2,
        name: "Personal",
        color: "#10B981",
        created_at: "2023-06-01T00:00:00.000000Z",
        updated_at: "2023-06-01T00:00:00.000000Z",
        todos_count: 2
      }
    ];

    const mockStatistics: Statistics = {
      total: 3,
      completed: 1,
      pending: 2,
      completion_rate: 33
    };

    setTodos(mockTodos);
    setCategories(mockCategories);
    setStatistics(mockStatistics);
    setLoading(false);
  }, []);

  const addTodo = (todo: Omit<Todo, 'id' | 'created_at' | 'updated_at' | 'is_completed' | 'subtasks_count' | 'completed_subtasks_count'>) => {
    const newTodo: Todo = {
      ...todo,
      id: todos.length + 1,
      created_at: new Date().toISOString(),
      updated_at: new Date().toISOString(),
      is_completed: todo.status === 'completed',
      subtasks_count: 0,
      completed_subtasks_count: 0
    };

    setTodos([...todos, newTodo]);
    updateStatistics();
  };

  const updateTodo = (id: number, updates: Partial<Todo>) => {
    const updatedTodos = todos.map(todo => {
      if (todo.id === id) {
        const updatedTodo = { ...todo, ...updates, updated_at: new Date().toISOString() };
        if (updates.status) {
          updatedTodo.is_completed = updates.status === 'completed';
        }
        return updatedTodo;
      }
      return todo;
    });

    setTodos(updatedTodos);
    updateStatistics();
  };

  const deleteTodo = (id: number) => {
    setTodos(todos.filter(todo => todo.id !== id));
    updateStatistics();
  };

  const addCategory = (category: Omit<Category, 'id' | 'created_at' | 'updated_at' | 'todos_count'>) => {
    const newCategory: Category = {
      ...category,
      id: categories.length + 1,
      created_at: new Date().toISOString(),
      updated_at: new Date().toISOString(),
      todos_count: 0
    };

    setCategories([...categories, newCategory]);
  };

  const updateCategory = (id: number, updates: Partial<Category>) => {
    const updatedCategories = categories.map(category => {
      if (category.id === id) {
        return { ...category, ...updates, updated_at: new Date().toISOString() };
      }
      return category;
    });

    setCategories(updatedCategories);
  };

  const deleteCategory = (id: number) => {
    // Update todos with this category to have null category_id
    const updatedTodos = todos.map(todo => {
      if (todo.category_id === id) {
        return { ...todo, category_id: null, category: undefined };
      }
      return todo;
    });

    setTodos(updatedTodos);
    setCategories(categories.filter(category => category.id !== id));
  };

  const updateStatistics = () => {
    const total = todos.length;
    const completed = todos.filter(todo => todo.is_completed).length;
    const pending = total - completed;
    const completion_rate = total > 0 ? Math.round((completed / total) * 100) : 0;

    setStatistics({
      total,
      completed,
      pending,
      completion_rate
    });
  };

  if (loading) {
    return <div className="loading">Loading...</div>;
  }

  if (error) {
    return <div className="error">Error: {error}</div>;
  }

  return (
    <Router>
      <div className="app">
        <Header statistics={statistics} />
        <main className="content">
          <Routes>
            <Route path="/" element={<Navigate to="/todos" replace />} />
            <Route
              path="/todos"
              element={
                <TodoList
                  todos={todos}
                  categories={categories}
                  onAddTodo={addTodo}
                  onUpdateTodo={updateTodo}
                  onDeleteTodo={deleteTodo}
                />
              }
            />
            <Route
              path="/todos/:id"
              element={
                <TodoDetail
                  todos={todos}
                  categories={categories}
                  onUpdateTodo={updateTodo}
                  onDeleteTodo={deleteTodo}
                />
              }
            />
            <Route
              path="/categories"
              element={
                <CategoryList
                  categories={categories}
                  onAddCategory={addCategory}
                  onUpdateCategory={updateCategory}
                  onDeleteCategory={deleteCategory}
                />
              }
            />
          </Routes>
        </main>
      </div>
    </Router>
  );
}

export default App; 
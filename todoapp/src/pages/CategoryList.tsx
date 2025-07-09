import React, { useState } from 'react';

interface Category {
  id: number;
  name: string;
  color: string;
  created_at: string;
  updated_at: string;
  todos_count: number;
}

interface CategoryListProps {
  categories: Category[];
  onAddCategory: (category: Omit<Category, 'id' | 'created_at' | 'updated_at' | 'todos_count'>) => void;
  onUpdateCategory: (id: number, updates: Partial<Category>) => void;
  onDeleteCategory: (id: number) => void;
}

const CategoryList: React.FC<CategoryListProps> = ({
  categories,
  onAddCategory,
  onUpdateCategory,
  onDeleteCategory
}) => {
  const [showAddForm, setShowAddForm] = useState<boolean>(false);
  const [editingCategoryId, setEditingCategoryId] = useState<number | null>(null);
  const [newCategory, setNewCategory] = useState<Omit<Category, 'id' | 'created_at' | 'updated_at' | 'todos_count'>>({
    name: '',
    color: '#4F46E5'
  });
  
  // Array of predefined colors
  const colorOptions = [
    '#4F46E5', // Indigo
    '#10B981', // Emerald
    '#EF4444', // Red
    '#F59E0B', // Amber
    '#3B82F6', // Blue
    '#8B5CF6', // Violet
    '#EC4899', // Pink
    '#64748B'  // Slate
  ];
  
  // Handle form input changes
  const handleInputChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>) => {
    const { name, value } = e.target;
    
    setNewCategory(prev => ({
      ...prev,
      [name]: value
    }));
  };
  
  // Handle form submission for adding a new category
  const handleAddSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    
    // Validate input
    if (!newCategory.name.trim()) {
      alert('Name is required');
      return;
    }
    
    // Add new category
    onAddCategory(newCategory);
    
    // Reset form
    setNewCategory({
      name: '',
      color: '#4F46E5'
    });
    
    // Hide form
    setShowAddForm(false);
  };
  
  // Handle form submission for editing a category
  const handleEditSubmit = (e: React.FormEvent, id: number) => {
    e.preventDefault();
    
    // Validate input
    if (!newCategory.name.trim()) {
      alert('Name is required');
      return;
    }
    
    // Update category
    onUpdateCategory(id, newCategory);
    
    // Reset editing state
    setEditingCategoryId(null);
    setNewCategory({
      name: '',
      color: '#4F46E5'
    });
  };
  
  // Start editing a category
  const startEditing = (category: Category) => {
    setEditingCategoryId(category.id);
    setNewCategory({
      name: category.name,
      color: category.color
    });
  };
  
  // Cancel editing
  const cancelEditing = () => {
    setEditingCategoryId(null);
    setNewCategory({
      name: '',
      color: '#4F46E5'
    });
  };
  
  // Handle delete confirmation
  const handleDelete = (id: number) => {
    // Check if there are todos using this category
    const category = categories.find(c => c.id === id);
    
    if (category && category.todos_count > 0) {
      const confirm = window.confirm(`This category is used by ${category.todos_count} todo(s). Deleting it will remove the category from these todos. Are you sure you want to proceed?`);
      
      if (!confirm) {
        return;
      }
    } else if (!window.confirm('Are you sure you want to delete this category?')) {
      return;
    }
    
    onDeleteCategory(id);
  };
  
  return (
    <div>
      <div className="card">
        <div className="card-title">Categories</div>
        
        <div className="card-actions">
          <button 
            className="btn btn-primary"
            onClick={() => setShowAddForm(!showAddForm)}
          >
            {showAddForm ? 'Cancel' : 'Add Category'}
          </button>
        </div>
        
        {/* Add Category Form */}
        {showAddForm && (
          <div className="card">
            <h3 className="card-title">Add New Category</h3>
            <form onSubmit={handleAddSubmit}>
              <div className="form-group">
                <label className="form-label">Name</label>
                <input 
                  type="text"
                  className="form-input"
                  name="name"
                  value={newCategory.name}
                  onChange={handleInputChange}
                  required
                />
              </div>
              
              <div className="form-group">
                <label className="form-label">Color</label>
                <div className="color-picker">
                  {colorOptions.map(color => (
                    <div 
                      key={color}
                      className={`color-option ${newCategory.color === color ? 'selected' : ''}`}
                      style={{ backgroundColor: color }}
                      onClick={() => setNewCategory(prev => ({ ...prev, color }))}
                    />
                  ))}
                </div>
                <input 
                  type="color"
                  className="form-input color-input"
                  name="color"
                  value={newCategory.color}
                  onChange={handleInputChange}
                />
              </div>
              
              <button type="submit" className="btn btn-primary">
                Add Category
              </button>
            </form>
          </div>
        )}
        
        {/* Category List */}
        <div className="category-list">
          {categories.map(category => (
            <div key={category.id} className="category-item">
              {editingCategoryId === category.id ? (
                // Edit form
                <form onSubmit={(e) => handleEditSubmit(e, category.id)}>
                  <div className="form-group">
                    <label className="form-label">Name</label>
                    <input 
                      type="text"
                      className="form-input"
                      name="name"
                      value={newCategory.name}
                      onChange={handleInputChange}
                      required
                    />
                  </div>
                  
                  <div className="form-group">
                    <label className="form-label">Color</label>
                    <div className="color-picker">
                      {colorOptions.map(color => (
                        <div 
                          key={color}
                          className={`color-option ${newCategory.color === color ? 'selected' : ''}`}
                          style={{ backgroundColor: color }}
                          onClick={() => setNewCategory(prev => ({ ...prev, color }))}
                        />
                      ))}
                    </div>
                    <input 
                      type="color"
                      className="form-input color-input"
                      name="color"
                      value={newCategory.color}
                      onChange={handleInputChange}
                    />
                  </div>
                  
                  <div className="form-actions">
                    <button type="submit" className="btn btn-primary">
                      Save
                    </button>
                    <button 
                      type="button"
                      className="btn btn-outline"
                      onClick={cancelEditing}
                    >
                      Cancel
                    </button>
                  </div>
                </form>
              ) : (
                // Display mode
                <>
                  <div className="category-header">
                    <div className="category-color" style={{ backgroundColor: category.color }} />
                    <div className="category-name">{category.name}</div>
                    <div className="category-count">{category.todos_count}</div>
                  </div>
                  
                  <div className="category-actions">
                    <button 
                      className="btn btn-sm btn-outline"
                      onClick={() => startEditing(category)}
                    >
                      Edit
                    </button>
                    <button 
                      className="btn btn-sm btn-danger"
                      onClick={() => handleDelete(category.id)}
                    >
                      Delete
                    </button>
                  </div>
                </>
              )}
            </div>
          ))}
          
          {categories.length === 0 && (
            <div className="empty-state">
              <p>No categories found</p>
              <p>Create a category to help organize your todos</p>
            </div>
          )}
        </div>
      </div>
    </div>
  );
};

export default CategoryList; 
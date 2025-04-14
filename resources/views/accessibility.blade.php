@extends('layouts.app')

@section('title', 'Accessibility Settings')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h1 class="h3 mb-0">Accessibility Settings</h1>
        </div>
        <div class="card-body">
            <p class="lead mb-4">Customize your experience with these accessibility options. Your preferences will be saved for future visits.</p>
            
            <div class="row">
                <!-- Text Size Controls -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header">
                            <h2 class="h5 mb-0">
                                <i class="fas fa-text-height me-2"></i>Text Size
                            </h2>
                        </div>
                        <div class="card-body">
                            <p>Adjust the size of text throughout the application.</p>
                            
                            <div class="btn-group w-100" role="group" aria-label="Text size options">
                                <button type="button" class="btn btn-outline-secondary" id="text-size-small">
                                    <i class="fas fa-font fa-sm"></i> Small
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="text-size-medium">
                                    <i class="fas fa-font"></i> Medium
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="text-size-large">
                                    <i class="fas fa-font fa-lg"></i> Large
                                </button>
                            </div>
                            
                            <div class="mt-3 small text-muted">
                                Keyboard shortcut: <span class="keyboard-shortcut">Alt</span> + <span class="keyboard-shortcut">T</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- High Contrast Mode -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header">
                            <h2 class="h5 mb-0">
                                <i class="fas fa-adjust me-2"></i>High Contrast
                            </h2>
                        </div>
                        <div class="card-body">
                            <p>Enable high contrast colors for better readability.</p>
                            
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="high-contrast-toggle">
                                <label class="form-check-label" for="high-contrast-toggle">
                                    High Contrast Mode
                                </label>
                                <span id="high-contrast-status" class="ms-2 badge bg-secondary">Off</span>
                            </div>
                            
                            <div class="mt-3 small text-muted">
                                Keyboard shortcut: <span class="keyboard-shortcut">Alt</span> + <span class="keyboard-shortcut">H</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Reduced Motion -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header">
                            <h2 class="h5 mb-0">
                                <i class="fas fa-running me-2"></i>Reduced Motion
                            </h2>
                        </div>
                        <div class="card-body">
                            <p>Minimize animations and motion effects.</p>
                            
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="reduced-motion-toggle">
                                <label class="form-check-label" for="reduced-motion-toggle">
                                    Reduced Motion
                                </label>
                                <span id="reduced-motion-status" class="ms-2 badge bg-secondary">Off</span>
                            </div>
                            
                            <div class="mt-3 small text-muted">
                                Keyboard shortcut: <span class="keyboard-shortcut">Alt</span> + <span class="keyboard-shortcut">M</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="alert alert-info mt-3">
                <i class="fas fa-info-circle me-2"></i>
                All accessibility settings are saved automatically and will be applied each time you visit.
                Visit our <a href="{{ route('help') }}" class="alert-link">Help page</a> to learn more about accessibility features.
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/textSize.js') }}"></script>
<script src="{{ asset('js/highContrast.js') }}"></script>
<script src="{{ asset('js/reducedMotion.js') }}"></script>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/text-size.css') }}">
<link rel="stylesheet" href="{{ asset('css/high-contrast.css') }}">
<link rel="stylesheet" href="{{ asset('css/reduced-motion.css') }}">
@endsection 
@endsection 
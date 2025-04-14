@extends('layouts.app')

@section('title', __('accessibility.settings_title'))

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h1 class="h3 mb-0">{{ __('accessibility.settings_title') }}</h1>
        </div>
        <div class="card-body">
            <p class="lead mb-4">{{ __('accessibility.description') }} {{ __('accessibility.preferences_saved') }}</p>
            
            <div class="row">
                <!-- Text Size Controls -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header">
                            <h2 class="h5 mb-0">
                                <i class="fas fa-text-height me-2"></i>{{ __('accessibility.text_size_title') }}
                            </h2>
                        </div>
                        <div class="card-body">
                            <p>{{ __('accessibility.text_size_description') }}</p>
                            
                            <div class="btn-group w-100" role="group" aria-label="Text size options">
                                <button type="button" class="btn btn-outline-secondary" id="text-size-small">
                                    <i class="fas fa-font fa-sm"></i> {{ __('accessibility.text_size_small') }}
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="text-size-medium">
                                    <i class="fas fa-font"></i> {{ __('accessibility.text_size_medium') }}
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="text-size-large">
                                    <i class="fas fa-font fa-lg"></i> {{ __('accessibility.text_size_large') }}
                                </button>
                            </div>
                            
                            <div class="mt-3 small text-muted">
                                {{ __('accessibility.keyboard_shortcut') }} <span class="keyboard-shortcut">Alt</span> + <span class="keyboard-shortcut">T</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- High Contrast Mode -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header">
                            <h2 class="h5 mb-0">
                                <i class="fas fa-adjust me-2"></i>{{ __('accessibility.contrast_title') }}
                            </h2>
                        </div>
                        <div class="card-body">
                            <p>{{ __('accessibility.contrast_description') }}</p>
                            
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="high-contrast-toggle">
                                <label class="form-check-label" for="high-contrast-toggle">
                                </label>
                                <span id="high-contrast-status" class="ms-2 badge bg-secondary">{{ __('accessibility.status_off') }}</span>
                            </div>
                            
                            <div class="mt-3 small text-muted">
                                {{ __('accessibility.keyboard_shortcut') }} <span class="keyboard-shortcut">Alt</span> + <span class="keyboard-shortcut">H</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Reduced Motion -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header">
                            <h2 class="h5 mb-0">
                                <i class="fas fa-running me-2"></i>{{ __('accessibility.motion_title') }}
                            </h2>
                        </div>
                        <div class="card-body">
                            <p>{{ __('accessibility.motion_description') }}</p>
                            
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="reduced-motion-toggle">
                                <label class="form-check-label" for="reduced-motion-toggle">
                                </label>
                                <span id="reduced-motion-status" class="ms-2 badge bg-secondary">{{ __('accessibility.status_off') }}</span>
                            </div>
                            
                            <div class="mt-3 small text-muted">
                                {{ __('accessibility.keyboard_shortcut') }} <span class="keyboard-shortcut">Alt</span> + <span class="keyboard-shortcut">M</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="alert alert-info mt-3">
                <i class="fas fa-info-circle me-2"></i>
                {{ __('accessibility.keyboard_shortcuts_info') }}
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
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-lg mb-4">
                <div class="card-header">
                    <h3 class="mb-0"><i class="fas fa-paper-plane me-2"></i>Submit News Inquiry</h3>
                </div>
                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" enctype="multipart/form-data" action="{{ url('/inquiries/submit') }}" class="needs-validation" novalidate>
                        @csrf
                        
                        <div class="mb-4">
                            <label for="news_detail" class="form-label">
                                <i class="fas fa-newspaper me-2"></i>News Details
                            </label>
                            <textarea name="news_detail" id="news_detail" class="form-control @error('news_detail') is-invalid @enderror" 
                                rows="5" placeholder="Provide detailed information about the news you want to verify..." required>{{ old('news_detail') }}</textarea>
                            @error('news_detail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Be specific and include as much information as possible to help with verification.
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="evidence" class="form-label">
                                <i class="fas fa-file-alt me-2"></i>Supporting Evidence
                            </label>
                            <div class="input-group mb-3">
                                <input type="file" class="form-control @error('evidence') is-invalid @enderror" 
                                    id="evidence" name="evidence[]" multiple>
                                <label class="input-group-text" for="evidence">
                                    <i class="fas fa-upload"></i>
                                </label>
                                @error('evidence')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text">
                                Upload images, documents, or videos that support your inquiry (Max: 10MB per file).
                                <br>Accepted formats: JPG, PNG, PDF, MP4, MOV
                            </div>
                            
                            <div id="preview-container" class="mt-3 row g-2 d-none">
                                <div class="col-12">
                                    <h6 class="mb-2">Selected Files:</h6>
                                </div>
                                <div id="file-preview" class="d-flex flex-wrap"></div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fas fa-link me-2"></i>Related Links
                            </label>
                            <div id="links-container">
                                <div class="input-group mb-2">
                                    <span class="input-group-text">
                                        <i class="fas fa-globe"></i>
                                    </span>
                                    <input type="text" name="links[]" class="form-control" 
                                        placeholder="Paste a URL (e.g., https://example.com/news-article)">
                                </div>
                            </div>
                            <button type="button" onclick="addLinkField()" class="btn btn-sm btn-outline-theme mt-1">
                                <i class="fas fa-plus me-1"></i>Add Another Link
                            </button>
                            <div class="form-text">
                                Include links to social media posts, news articles, or websites related to this inquiry.
                            </div>
                        </div>
                        
                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="consent" required>
                            <label class="form-check-label" for="consent">
                                I confirm that the information provided is accurate to the best of my knowledge
                            </label>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="button" class="btn btn-outline-theme" onclick="window.history.back()">
                                <i class="fas fa-arrow-left me-1"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-theme-primary">
                                <i class="fas fa-paper-plane me-1"></i>Submit Inquiry
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Submission Guidelines</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0 text-primary me-3">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                                <div>
                                    <h6>Be Specific</h6>
                                    <p class="text-muted small">Include exact quotes, dates, and sources of the news you're inquiring about.</p>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0 text-primary me-3">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                                <div>
                                    <h6>Provide Context</h6>
                                    <p class="text-muted small">Explain why you believe this news needs verification.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0 text-primary me-3">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                                <div>
                                    <h6>Include Evidence</h6>
                                    <p class="text-muted small">Screenshots, documents, or links help expedite the verification process.</p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="flex-shrink-0 text-primary me-3">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                                <div>
                                    <h6>Be Patient</h6>
                                    <p class="text-muted small">Verification may take time as our team works with relevant agencies.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
function addLinkField() {
    const container = document.getElementById('links-container');
    const newField = document.createElement('div');
    newField.className = 'input-group mb-2';
    newField.innerHTML = `
        <span class="input-group-text">
            <i class="fas fa-globe"></i>
        </span>
        <input type="text" name="links[]" class="form-control" 
            placeholder="Paste a URL (e.g., https://example.com/news-article)">
        <button class="btn btn-outline-danger" type="button" onclick="removeLink(this)">
            <i class="fas fa-times"></i>
        </button>
    `;
    container.appendChild(newField);
}

function removeLink(button) {
    button.closest('.input-group').remove();
}

// File preview functionality
document.getElementById('evidence').addEventListener('change', function(e) {
    const previewContainer = document.getElementById('preview-container');
    const filePreview = document.getElementById('file-preview');
    filePreview.innerHTML = '';
    
    if (this.files.length > 0) {
        previewContainer.classList.remove('d-none');
        
        Array.from(this.files).forEach((file, index) => {
            const fileItem = document.createElement('div');
            fileItem.className = 'file-item p-2 border rounded me-2 mb-2 d-flex align-items-center';
            
            let fileIcon = 'fa-file';
            if (file.type.startsWith('image/')) {
                fileIcon = 'fa-file-image';
            } else if (file.type.startsWith('video/')) {
                fileIcon = 'fa-file-video';
            } else if (file.type === 'application/pdf') {
                fileIcon = 'fa-file-pdf';
            }
            
            fileItem.innerHTML = `
                <i class="fas ${fileIcon} me-2 text-primary"></i>
                <span class="small">${file.name.length > 20 ? file.name.substring(0, 20) + '...' : file.name}</span>
            `;
            
            filePreview.appendChild(fileItem);
        });
    } else {
        previewContainer.classList.add('d-none');
    }
});
</script>
@endsection
@endsection
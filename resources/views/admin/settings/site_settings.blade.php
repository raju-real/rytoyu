@extends('admin.layouts.app')
@section('title','Site Settings')
@push('css') @endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Site Settings</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.update-site-settings') }}" method="POST" id="prevent-form"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Company Name {!! starSign() !!}</label>
                                    <input type="text" name="company_name"
                                           value="{{ old('company_name') ?? siteSettings()['company_name'] ?? '' }}"
                                           class="form-control {{ hasError('company_name') }}"
                                           placeholder="Company Name">
                                    @error('company_name')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Company Email</label>
                                    <input type="text" name="company_email"
                                           value="{{ old('company_email') ?? siteSettings()['company_email'] ?? '' }}"
                                           class="form-control {{ hasError('company_email') }}"
                                           placeholder="Company Email">
                                    @error('company_email')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Company Mobile</label>
                                    <input type="text" name="company_mobile"
                                           value="{{ old('company_mobile') ?? siteSettings()['company_mobile'] ?? '' }}"
                                           class="form-control {{ hasError('company_mobile') }}"
                                           placeholder="Company Mobile">
                                    @error('company_mobile')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Company Phone</label>
                                    <input type="text" name="company_phone"
                                           value="{{ old('company_phone') ?? siteSettings()['company_phone'] ?? '' }}"
                                           class="form-control {{ hasError('company_phone') }}"
                                           placeholder="Company Phone">
                                    @error('company_phone')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label d-flex align-items-center justify-content-between">
                                        <span>Logo (Type: jpg, jpeg, png, Max: 1MB)</span>
                                        @if(isset(siteSettings()['logo']) && file_exists(siteSettings()['logo']))
                                            <button type="button"
                                                    class="custom-badge badge-info view-image"
                                                    data-image-url="{{ asset(siteSettings()['logo']) }}"
                                                    title="View Image">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        @endif
                                    </label>
                                    <input type="file" name="logo" class="form-control {{ hasError('logo') }}"
                                           accept=".jpg, .jpeg, .png">
                                    @error('logo')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label d-flex align-items-center justify-content-between">
                                        <span>Favicon (Type: png,ico Max: 1MB)</span>
                                        @if(isset(siteSettings()['favicon']) && file_exists(siteSettings()['favicon']))
                                            <button type="button"
                                                    class="custom-badge badge-info view-image"
                                                    data-image-url="{{ asset(siteSettings()['favicon']) }}"
                                                    title="View Image">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        @endif
                                    </label>
                                    <input type="file" name="favicon" class="form-control {{ hasError('favicon') }}"
                                           accept=".png">
                                    @error('favicon')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea name="address" id="address" cols="30" rows="1"
                                              class="form-control {{ hasError('address') }}"
                                              placeholder="Address">{{ old('address') ?? siteSettings()['address'] ?? '' }}</textarea>
                                    @error('address')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Slogan</label>
                                    <input type="text" name="slogan"
                                           value="{{ old('slogan') ?? siteSettings()['slogan'] ?? '' }}"
                                           class="form-control {{ hasError('slogan') }}"
                                           placeholder="Slogan">
                                    @error('slogan')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Website URL</label>
                                    <input type="text" name="website_url"
                                           value="{{ old('website_url') ?? siteSettings()['website_url'] ?? '' }}"
                                           class="form-control {{ hasError('website_url') }}"
                                           placeholder="Website URL">
                                    @error('website_url')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Facebook URL</label>
                                    <input type="text" name="facebook_url"
                                           value="{{ old('facebook_url') ?? siteSettings()['facebook_url'] ?? '' }}"
                                           class="form-control {{ hasError('facebook_url') }}"
                                           placeholder="Facebook URL">
                                    @error('facebook_url')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Linkedin URL</label>
                                    <input type="text" name="linkedin_url"
                                           value="{{ old('linkedin_url') ?? siteSettings()['linkedin_url'] ?? '' }}"
                                           class="form-control {{ hasError('linkedin_url') }}"
                                           placeholder="Linkedin URL">
                                    @error('linkedin_url')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Youtube URL</label>
                                    <input type="text" name="youtube_url"
                                           value="{{ old('youtube_url') ?? siteSettings()['youtube_url'] ?? '' }}"
                                           class="form-control {{ hasError('youtube_url') }}"
                                           placeholder="Youtube URL">
                                    @error('youtube_url')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Google Map URL</label>
                                    <input type="text" name="google_map_url"
                                           value="{{ old('google_map_url') ?? siteSettings()['google_map_url'] ?? '' }}"
                                           class="form-control {{ hasError('google_map_url') }}"
                                           placeholder="Google Map URL">
                                    @error('google_map_url')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Footer Text</label>
                                    <textarea name="footer_text" id="footer_text" cols="30" rows="5"
                                              class="form-control {{ hasError('footer_text') }}"
                                              placeholder="Footer Text">{{ old('footer_text') ?? siteSettings()['footer_text'] ?? '' }}</textarea>
                                    @error('footer_text')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Support Policy</label>
                                    <textarea class="form-control" name="support_policy"
                                              id="support_policy">{{ old('support_policy') ?? siteSettings()['support_policy'] ?? '' }}</textarea>
                                    @error('support_policy')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Return Policy</label>
                                    <textarea class="form-control" name="return_policy"
                                              id="return_policy">{{ old('return_policy') ?? siteSettings()['return_policy'] ?? '' }}</textarea>
                                    @error('return_policy')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">About Us</label>
                                    <textarea class="form-control" name="about_us"
                                              id="about_us">{{ old('about_us') ?? siteSettings()['about_us'] ?? '' }}</textarea>
                                    @error('about_us')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Mission & Vision</label>
                                    <textarea class="form-control" name="mission_and_vision"
                                              id="mission_and_vision">{{ old('mission_and_vision') ?? siteSettings()['mission_and_vision'] ?? '' }}</textarea>
                                    @error('mission_and_vision')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div>
                            <x-submit-button></x-submit-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        let config = {
            toolbar: [
                ['Bold', 'Italic', 'Strike', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'NumberedList', 'BulletedList'],
            ]
        };

        CKEDITOR.config.allowedContent = true;
        CKEDITOR.replace('support_policy', config);
        CKEDITOR.replace('return_policy', config);
        CKEDITOR.replace('about_us', config);
        CKEDITOR.replace('mission_and_vision', config);
    </script>
@endpush

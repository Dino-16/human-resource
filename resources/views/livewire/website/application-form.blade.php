<div @class(['p-5'])>

    <a @class(['nav-link', 'text-secondary']) href="{{ route('careers') }}"><i class="bi bi-arrow-left-circle me-2"></i>Back to Jobs</a>

    <div @class(['container'])>

        {{-- Title --}}
        <h2 @class(['mb-5'])>
            Application Form - <span @style(['color: #213A5C;'])>{{ $job->position }}</span>
        </h2>

        {{-- Success --}}
        <x-alert-success />

    
        {{-- Form --}}
        <form wire:submit.prevent="submitApplication">
            <div @class(['row'])>

                {{-- Job Name --}}
                <x-text-input wire:model="job" type="hidden" />

                {{-- Description Title --}}
                <h3 @class(['mb-3'])>Name</h3>

                {{-- Applicant Last Name --}}
                <div @class(['col-md-3', 'mb-3'])>
                    <div>
                        <x-input-label for="last-name" :value="__('Last Name')" />
                        <x-text-input wire:model="applicantLastName" type="text" id="last-name" required />
                        <x-input-error field="applicantLastName" />
                    </div>
                </div>

                {{-- Applicant First Name --}}
                <div @class(['col-md-3', 'mb-3'])>
                    <div>
                        <x-input-label for="first-name" :value="__('First Name')" />
                        <x-text-input wire:model="applicantFirstName" type="text" id="first-name" required />
                        <x-input-error field="applicantFirstName" />
                    </div>
                </div>

                {{-- Applicant Middle Name --}}
                <div @class(['col-md-3', 'mb-3'])>
                    <div>
                        <x-input-label for="middle-name" :value="__('Middle Name')" />
                        <x-text-input wire:model="applicantMiddleName" type="text" id="middle-name" required />
                        <x-input-error field="applicantMiddleName" />
                    </div>
                </div>

                {{-- Applicant Suffix Name --}}
                <div @class(['col-md-3', 'mb-3'])>
                    <div>
                        <x-input-label for="suffix-name" :value="__('Suffix')" />
                        <x-text-input wire:model="applicantSuffixName" type="text" id="suffix-name" />
                        <x-input-error field="applicantSuffixName" />
                    </div>
                </div>

                {{-- Description Title --}}
                <h3 @class(['mb-3'])>Current Address</h3>

                {{-- Applicant Address --}}
                <div @class(['col-md-12', 'mb-3'])>
                    <x-input-label for="applicant-address" :value="__('Full Address')" />
                    <x-text-input wire:model="applicantAddress" type="text" id="applicant-address" required />
                    <x-input-error field="applicantAddress" />
                </div>

                {{-- Description Title --}}
                <h3 @class(['mb-3'])>Contact Information</h3>

                {{-- Applicant Email --}}
                <div @class(['col-md-6', 'mb-3'])>
                    <x-input-label for="applicant-email" :value="__('Email')" />
                    <x-text-input wire:model="applicantEmail" type="email" id="applicant-email" required />
                    <x-input-error field="applicantEmail" />
                </div>

                {{-- Applicant Phone --}}
                <div @class(['col-md-6', 'mb-3'])>
                    <x-input-label for="applicant-phone" :value="__('Phone Number')" />
                    <x-text-input wire:model="applicantPhone" type="number" id="applicant-phone" required />
                    <x-input-error field="applicantPhone" />
                </div>

                {{-- Description Title --}}
                <h3 @class(['mb-3'])>Upload a Resume</h3>

                <div @class(['col-md-12', 'mb-3'])>
                    <label for="resume" @class(['w-100'])>
                        <input 
                            wire:model="applicantResumeFile" 
                            type="file" 
                            accept=".pdf,.doc,.docx" 
                            id="resume" 
                            required 
                            @class(['d-none']) 
                        />
                        <div @class(['d-flex', 'flex-column', 'justify-content-center', 'align-items-center', 'p-5', 'border', 'rounded', 'bg-white', 'text-center']) @style(['cursor' => 'pointer', 'height' => '120px'])>
                            <i @class(['bi', 'bi-cloud-upload', 'fs-1', 'text-secondary', 'mb-2'])></i>
                            <span @class(['text-muted', 'pb-1'])>Upload your resume here</span>
                        </div>
                    </label>

                    <x-input-error field="applicantResumeFile" />

                    <div @class(['mt-3'])>
                        <div wire:loading.delay wire:target="applicantResumeFile" class="mt-3 text-success" style="font-size: 1rem;">
                            <span class="spinner-border text-success" role="status" style="vertical-align: middle; display: inline-block;">
                                <span class="visually-hidden">Loading...</span>
                            </span>
                            <span style="vertical-align: middle; display: inline-block; margin-left: 8px;">
                                Uploading . . . . .
                            </span>
                        </div>
                    </div>

                    @if ($applicantResumeFile)
                        <div class="text-muted small mt-2">
                            Selected file: {{ $applicantResumeFile->getClientOriginalName() }}
                        </div>
                    @endif
                </div>

                <div wire:loading.delay wire:target="save" class="text-center text-success" style="font-size: 1rem;">
                    <span class="spinner-border text-success" role="status" style="vertical-align: middle; display: inline-block;">
                        <span class="visually-hidden">Loading...</span>
                    </span>
                    <span style="vertical-align: middle; display: inline-block; margin-left: 8px;">
                        Sending . . . . .
                    </span>
                </div>

                {{-- Terms Agreement --}}
                <div class="col-md-12 mb-4">
                    <div class="form-check">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            id="agreed-to-terms" 
                            wire:model="agreedToTerms"
                        >
                        <label class="form-check-label" for="agreed-to-terms">
                            I agree to the 
                            <a href="#" class="text-decoration-underline" data-bs-toggle="modal" data-bs-target="#privacyModal">terms and conditions</a>.
                        </label>
                        @error('agreedToTerms') <p class="text-danger ">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Submit Button --}}
                <div @class(['text-end'])>
                    <x-button-primary type="submit">Submit</x-button-primary>
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="privacyModalLabel">Privacy Statement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>
                    At Jetlouge Travel, we are dedicated to protecting the privacy and personal data of all individuals who engage with our travel and tour recruitment services. When you apply or register with us, we collect only the necessary information such as your name, contact details, work history, and relevant travel documents to match you with suitable travel industry roles and experiences. All personal data is treated as strictly confidential and used exclusively for recruitment, placement, and coordination purposes within the travel and tourism sector.
                    </p>
                    <p>
                    We do not share your information with third parties without your explicit consent, except when required by law or essential for processing your application with trusted partners. Jetlouge Travel uses secure systems and follows industry best practices to ensure your information remains protected. By using our services, you agree to the collection and use of your data as described in this statement. If you wish to access, update, or request deletion of your personal information, please reach out to our privacy team at any time.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>
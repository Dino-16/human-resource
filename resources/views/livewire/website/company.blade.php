<div>
    {{-- Hero Section --}}
    <div @class('d-flex justify-content-center align-items-center vh-100 flex-column bg-primary-subtle fade-section')
    style="background: url({{ asset('images/company.jpg') }}) no-repeat center center / cover ;">
        <h1 @class('text-center display-1 fw-bold text-white')><span @class('fw-bold text-white')>Welcome</span> to Jetlouge</h1>
        <h1 @class('text-center display-1 fw-bold text-white mb-5')>Travel and Tours!</h1>
        <a @class('btn btn-primary btn-lg') href="#">GET STARTED</a>
    </div>

    {{-- Intro Section --}}
    <div @class('bg-tertiary p-5 mx-5')>
        <h1 @class('my-5 display-3 text-primary fw-bold')>Jetlouge Travel and Tour Company</h1>
        <p @class('fs-4')>
            Our platform empowers job seekers by providing intelligent job-matching   tools,
            personalized opportunities, and a simplified   application process. At the same time,
            it supports employers with automated screening, secure applicant tracking,
            and access to a wide pool of qualified candidates nationwide. By combining AI innovation,
            industry-focused solutions, and a user-friendly experience,
            Jetlouge Travels bridges the gap between talent and opportunity into helping travel and tours
            organizations build strong teams while guiding professionals toward meaningful careers.
        </p>
    </div>

    {{--  MISSION VISION --}}
    <div @class('container bg-white my-5')>
        <div @class('row justify-content-center align-items-stretch gap-5')>
            {{-- MISSION --}}
            <div @class('col-12 col-md-6 col-lg-4 bg-secondary text-white p-5 rounded')>
                <h1 @class('text-center mb-5')>Company's Mission</h1>
                <p @class('mb-5 fs-5')>-To simplify and modernize the recruitment process through technology.</p>
                <p @class('mb-5 fs-5')>-To provide equal access to job opportunities for all applicants.</p>
                <p @class('mb-5 fs-5')>-To support employers in finding the right candidates efficiently.</p>
            </div>
            {{-- VISION --}}
            <div @class('col-12 col-md-6 col-lg-4 bg-secondary text-white p-5 rounded')>
                <h1 @class('text-center mb-5')>Company's Vision</h1>
                <p @class('text-white fs-5')>
                    To be the most trusted and efficient job portal,
                    empowering businesses to hire effectively and helping
                    individuals achieve their career goals.
                </p>
            </div>
        </div>
    </div>

    {{-- Features Section --}}
    <div @class('p-5')>
        <div @class('p-5')>
            <h1 @class('text-center text-primary display-3 fw-bold mb-5')>Jetlouge Travel and Tours Core Values</h1>
        </div>
        <div @class('p-5 mt-5')>
              <div class="d-flex align-items-center justify-content-around gap-3">
                {{-- Shape 1 --}}
                <div @class('d-flex align-items-center justify-content-center flex-column')>
                    <div >@class('d-flex align-items-center justify-content-center flex-column')
                        <div @class('bg-primary rounded-circle d-flex align-items-center justify-content-center position-absolute')
                            style="width: 200px; height: 200px;">
                            <p @class('text-white text-center p-3')>Customer Centered Service</p>
                        </div>
                    </div>
                    <div @class('d-flex align-items-center justify-content-center border mt-3 p-5  rounded')>
                        <div @class('mt-5')>
                            We put ur travelers at the heart of everything we do, ensuring personalized experiences that meet their unique needs.
                        </div>
                    </div>
                </div>

                {{-- Shape 2--}}
                <div @class('d-flex align-items-center justify-content-center flex-column')>
                    <div @class('d-flex align-items-center justify-content-center flex-column')>
                        <div @class('bg-primary rounded-circle d-flex align-items-center justify-content-center position-absolute')
                            style="width: 200px; height: 200px;">
                            <p @class('text-white text-center p-3')>Excellence and Reliability</p>
                        </div>
                    </div>
                    <div @class('d-flex align-items-center justify-content-center border mt-3 p-5  rounded')>
                        <div @class('mt-5')>
                           We uphold the highest standards of service, delivering trustworthy, seamless, and hassle-free travel experiences.
                        </div>
                    </div>
                </div>

                {{-- Shape 3 --}}
                <div @class('d-flex align-items-center justify-content-center flex-column')>
                    <div class="d-flex align-items-center justify-content-center flex-column">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center position-absolute"
                            style="width: 200px; height: 200px;">
                            <p class="text-white text-center p-3">Innovation in Travel</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center border mt-3 p-5  rounded">
                        <div class="mt-5">
                            We embrace technology and fresh ideas to create smarter, more efficient, and exciting ways to explore the world.
                        </div>
                    </div>
                </div>

                {{-- Shape 4 --}}
                <div class="d-flex align-items-center justify-content-center flex-column">
                    <div class="d-flex align-items-center justify-content-center flex-column">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center position-absolute"
                            style="width: 200px; height: 200px;">
                            <p class="text-white text-center p-3">Integrity and Transparency</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center border mt-3 p-5  rounded">
                        <div class="mt-5">
                            We conduct business with honesty, fairness, and openness, building lasting trust with our clients and partners.
                        </div>
                    </div>
                </div>

                 {{-- Shape 5 --}}
                <div class="d-flex align-items-center justify-content-center flex-column">
                    <div class="d-flex align-items-center justify-content-center flex-column">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center position-absolute"
                            style="width: 200px; height: 200px;">
                            <p class="text-white text-center p-3">Passion for Exploration   </p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center border mt-3 p-5  rounded">
                        <div class="mt-5">
                            We believe travel is more than reaching destinations—its about discovery, growth, and creating meaningful memories.
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

</div>

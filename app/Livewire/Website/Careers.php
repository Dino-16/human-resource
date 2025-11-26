<?php

namespace App\Livewire\Website;

use Livewire\Component;

class Careers extends Component
{
    public $showDetails = false;

    public $jobs = [
        [
            'title' => 'Logistic Coordinator',
            'type' => 'Full Time',
            'location' => 'On-Site',
            'description' => 'The Logistic Coordinator plays a critical role in managing the end-to-end supply chain operations.',
            'full_description' => 'The Logistic Coordinator plays a critical role in managing the end-to-end supply chain operations. This includes planning, coordinating, and monitoring the movement of goods from suppliers to customers, ensuring timely delivery, cost efficiency, and compliance with company standards. The role requires close collaboration with vendors, warehouse teams, and transportation providers to maintain optimal inventory levels and resolve logistical challenges.',
            'qualifications' => [
                "Bachelor's degree in Logistics, Supply Chain Management, Business Administration, or a related field",
                'Minimum of 2–3 years experience in logistics or supply chain coordination',
                'Strong analytical and organizational skills with attention to detail',
                'Proficiency in logistics software and ERP systems (e.g., SAP, Oracle)',
                'Excellent communication and negotiation abilities',
                'Ability to work under pressure and manage multiple priorities simultaneously'
            ],
            'responsibilities' => [
                'Coordinate and monitor supply chain operations including shipping, receiving, and inventory tracking',
                'Communicate with suppliers, carriers, and internal teams to ensure smooth logistics flow',
                'Prepare and maintain accurate documentation for shipments and deliveries',
                'Analyze delivery performance and identify areas for improvement',
                'Resolve issues related to delays, damages, or discrepancies in shipments',
                'Ensure compliance with safety, quality, and regulatory standards in all logistics activities'
            ]
        ],
        [
            'title' => 'Senior Software Developer',
            'type' => 'Full Time',
            'location' => 'Remote',
            'description' => 'The Senior Software Developer will be responsible for designing, developing, and implementing complex software solutions.',
            'full_description' => 'The Senior Software Developer will be responsible for designing, developing, and implementing complex software solutions. This role requires strong technical expertise and the ability to lead development projects from conception to deployment. The ideal candidate will work closely with cross-functional teams to deliver high-quality software that meets business requirements and industry standards.',
            'qualifications' => [
                "Bachelor's or Master's degree in Computer Science or related field",
                '5+ years of experience in software development',
                'Proficiency in multiple programming languages (e.g., JavaScript, Python, Java)',
                'Experience with modern web frameworks (e.g., React, Angular, Vue.js)',
                'Strong understanding of database design and optimization',
                'Experience with cloud platforms (AWS, Azure, or GCP)'
            ],
            'responsibilities' => [
                'Design and develop high-quality, scalable, and maintainable code',
                'Lead code reviews and mentor junior developers',
                'Collaborate with product managers and designers to define requirements',
                'Implement automated testing and continuous integration/continuous deployment (CI/CD) pipelines',
                'Troubleshoot and debug complex technical issues',
                'Stay current with emerging technologies and industry trends'
            ]
        ],
        [
            'title' => 'Marketing Manager',
            'type' => 'Full Time',
            'location' => 'Hybrid',
            'description' => 'The Marketing Manager will be responsible for developing and implementing comprehensive marketing strategies to promote our products and services.',
            'full_description' => 'The Marketing Manager will be responsible for developing and implementing comprehensive marketing strategies to promote our products and services. This role requires a creative and analytical thinker who can develop data-driven marketing campaigns, manage budgets, and lead a team of marketing professionals to achieve business objectives.',
            'qualifications' => [
                "Bachelor's degree in Marketing, Business Administration, or related field",
                '5+ years of experience in marketing, with at least 2 years in a management role',
                'Proven track record of developing and executing successful marketing campaigns',
                'Strong analytical skills and experience with marketing analytics tools',
                'Excellent communication and leadership abilities',
                'Experience with digital marketing channels and social media platforms'
            ],
            'responsibilities' => [
                'Develop and implement comprehensive marketing strategies',
                'Manage and allocate marketing budget effectively',
                'Oversee the creation of marketing materials and content',
                'Analyze market trends and competitor activities',
                'Lead and mentor the marketing team',
                'Measure and report on the performance of marketing campaigns',
            ]
        ],
        [
            'title' => 'Customer Support Specialist',
            'type' => 'Part Time',
            'location' => 'Remote',
            'description' => 'The Customer Support Specialist will be the first point of contact for our customers, providing timely and effective solutions to their inquiries and issues.',
            'full_description' => 'The Customer Support Specialist will be the first point of contact for our customers, providing timely and effective solutions to their inquiries and issues. This role requires excellent communication skills, problem-solving abilities, and a customer-centric approach to ensure high levels of customer satisfaction.',
            'qualifications' => [
                'High school diploma or equivalent (Bachelor\'s degree preferred)',
                '1-2 years of experience in customer service or support role',
                'Excellent verbal and written communication skills',
                'Strong problem-solving and conflict-resolution abilities',
                'Proficiency with customer support software and CRM systems',
                'Ability to work flexible hours, including weekends and holidays'
            ],
            'responsibilities' => [
                'Respond to customer inquiries via phone, email, and chat',
                'Resolve customer issues and complaints in a timely manner',
                'Maintain accurate records of customer interactions',
                'Escalate complex issues to the appropriate department',
                'Provide product information and guidance to customers',
                'Gather customer feedback and share with relevant teams'
            ]
        ]
    ];

    public function viewDetails()
    {
        $this->showDetails = !$this->showDetails;
        $this->dispatch('detailsToggled');
    }

    public function remove()
    {
        $this->showDetails = false;
    }

    public function render()
    {
        return view('livewire.website.careers', [
            'jobs' => $this->jobs,
            'showDetails' => $this->showDetails
        ])->layout('layouts.website');
    }
}

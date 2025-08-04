@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-6">About Medium Clone</h1>
        
        <div class="prose prose-lg max-w-none">
            <p class="text-gray-700 mb-6">
                Welcome to Medium Clone, a platform designed to empower writers and readers to connect through meaningful content. 
                Our platform is built with modern technologies and focuses on providing an exceptional reading and writing experience.
            </p>

            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Our Mission</h2>
            <p class="text-gray-700 mb-6">
                We believe in the power of words to inspire, educate, and transform. Our mission is to create a space where:
            </p>
            <ul class="list-disc pl-6 mb-6 text-gray-700">
                <li>Writers can share their stories, knowledge, and perspectives</li>
                <li>Readers can discover high-quality content tailored to their interests</li>
                <li>Communities can form around shared passions and ideas</li>
            </ul>

            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Features</h2>
            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <div class="border border-gray-200 rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">For Writers</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li>✍️ Rich text editor for beautiful articles</li>
                        <li>📊 Analytics to track your content's performance</li>
                        <li>🏷️ Organize content with tags and categories</li>
                        <li>📚 Create series for connected articles</li>
                    </ul>
                </div>
                <div class="border border-gray-200 rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">For Readers</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li>🎯 Personalized content recommendations</li>
                        <li>👏 Clap for articles you love</li>
                        <li>💬 Engage through comments</li>
                        <li>🔖 Bookmark articles for later</li>
                    </ul>
                </div>
            </div>

            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Technology Stack</h2>
            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <ul class="grid grid-cols-2 md:grid-cols-3 gap-4 text-gray-700">
                    <li>• Laravel Framework</li>
                    <li>• Tailwind CSS</li>
                    <li>• Alpine.js</li>
                    <li>• MySQL Database</li>
                    <li>• Filament Admin</li>
                    <li>• Modern PHP</li>
                </ul>
            </div>

            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Join Our Community</h2>
            <p class="text-gray-700 mb-6">
                Whether you're a writer looking to share your voice or a reader seeking quality content, 
                Medium Clone is the perfect place for you. Join our growing community today and be part 
                of the conversation.
            </p>

            <div class="bg-gray-50 rounded-lg p-6 text-center">
                <p class="text-lg font-medium text-gray-900 mb-4">Ready to get started?</p>
                <div class="space-x-4">
                    <a href="{{ route('register') }}" class="inline-block bg-black text-white px-6 py-2 rounded-full hover:bg-gray-800 transition">Sign Up</a>
                    <a href="{{ route('login') }}" class="inline-block bg-white text-black px-6 py-2 rounded-full border border-black hover:bg-gray-50 transition">Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
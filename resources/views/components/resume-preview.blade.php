<div class="bg-white rounded-lg shadow-lg p-6">
  <h1 class="text-4xl font-bold text-gray-900" x-text="resume.personal.name || 'Your Name'"></h1>
  <p class="text-xl text-gray-600 mt-1" x-text="resume.personal.title || 'Professional Title'"></p>
  <div class="mt-4 text-gray-700">
    <p x-text="'📧 ' + (resume.personal.email || 'your@email.com')"></p>
    <p x-text="'📱 ' + (resume.personal.phone || 'Your phone number')"></p>
  </div>
</div>


<div class="bg-white rounded-lg shadow-md p-6">
  <h2 class="text-2xl font-bold mb-4">Personal Information</h2>

  <input x-model="resume.personal.name" type="text" placeholder="Full Name"
    class="w-full px-4 py-3 mb-3 border rounded-lg focus:ring-2 focus:ring-blue-500">

  <input x-model="resume.personal.title" type="text" placeholder="Professional Title"
    class="w-full px-4 py-3 mb-3 border rounded-lg focus:ring-2 focus:ring-blue-500">

  <div class="grid grid-cols-2 gap-4">
    <input x-model="resume.personal.email" type="email" placeholder="Email"
      class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
    <input x-model="resume.personal.phone" type="tel" placeholder="Phone"
      class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
  </div>
</div>


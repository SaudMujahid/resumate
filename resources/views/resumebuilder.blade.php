@extends('layouts.app')

@section('content')
<div
  x-data="resumeBuilder()"
  class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 p-4"
>
  <div class="max-w-7xl mx-auto">

    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6 flex justify-between items-center">
      <div>
        <h1 class="text-3xl font-bold text-gray-900">Resume Builder</h1>
        <p class="text-gray-600 mt-1">Create your professional resume in minutes</p>
      </div>

      <div class="flex gap-3">
        <button
          @click="showPreview = !showPreview"
          class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
        >
          <span x-text="showPreview ? 'Edit' : 'Preview'"></span>
        </button>

        <button class="flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
          Export PDF
        </button>
      </div>
    </div>

    <!-- Toggle between Preview and Editor -->
    <template x-if="showPreview">
      @include('components.resume-preview')
    </template>

    <template x-if="!showPreview">
      @include('components.resume-editor')
    </template>

  </div>
</div>
@endsection


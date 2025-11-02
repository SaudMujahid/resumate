@extends('layouts.home')

@section('content')
    {{-- Hero Section --}}

<section
    class="max-w-[1440px] mx-auto flex flex-col md:flex-row justify-between items-center px-6 py-12 md:py-16"
    x-data="{ show: false }"
    x-init="setTimeout(() => show = true, 200)"
>
    <div class="max-w-[550px] text-center md:text-left space-y-6">
        <h1
            x-show="show"
            x-transition
            class="font-[Playfair_Display] text-[56px] md:text-[72px] font-bold leading-[1.2] text-[#1C1C3C] mb-4"
        >
            Your Resume Mate
        </h1>

        <p
            x-show="show"
            x-transition.delay.150ms
            class="text-lg md:text-2xl text-[#1C1C3C]/80 mb-8"
        >
            Create a professional resume in minutes with our AI-powered builder.
        </p>

        <div class="flex justify-center md:justify-start gap-4 py-6">
            <a href="{{ route('register') }}" class="bg-[#FF6F61] text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-[#FF8C7A] transition">
                Get Started Free
            </a>
            <a href="{{ url('/features') }}" class="border border-[#1C1C3C] px-8 py-3 rounded-lg text-[#1C1C3C] font-semibold hover:bg-[#1C1C3C] hover:text-white transition">
                Learn More
            </a>
        </div>
    </div>

    <div
        x-show="show"
        x-transition.duration.700ms
        class="w-full md:w-[720px] mt-10 md:mt-0 flex justify-center"
    >
    <div class="relative w-full max-w-[600px] h-auto animate-float">
    {{-- svg from iconscout --}}
            <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" viewBox="0 0 6000 6000" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" id="Interestonresume">
  <path d="M1469.51 1161.55c-44.95 0-81.38 36.43-81.38 81.37 0 19.27 6.84 37.92 19.3 52.62l46.56-39.46a20.343 20.343 0 0 1-4.83-13.16c0-11.23 9.11-20.34 20.35-20.34v-61.03ZM1418.37 1306.23a81.418 81.418 0 0 0 51.14 18.07c43.53 0 79.35-34.26 81.29-77.75l-40.65-1.81c-.97 21.74-18.88 38.87-40.64 38.87-9.31 0-18.33-3.19-25.57-9.03l-25.57 31.65ZM1549.57 1228.37c-6.06-33.35-32.16-59.45-65.51-65.51l-5.17 28.44c21.5 3.91 38.33 20.74 42.24 42.24l28.44-5.17Z" transform="scale(-9.87773 9.87773)rotate(-47.224 -452.813 2601.623)" fill="#eeeeee" class="coloreeeeee svgShape"></path>
  <path d="M1365.08 1065.12c-26.72-12.33-61.94-72.6-30.33-94.292 18.6-12.761 45.37-8.927 66.65-10.884 36.48-3.355 71.92-17.237 94.88-46.918 49.05-63.424 25.7-213.985 141.81-208.11 49.45 2.501 88.81 36.182 108.31 79.971 10.32 23.16 16.09 54.585 34.28 73.246 20.03 20.538 53.93 5.599 78.38 4.653 18.92-.733 29.9 11.507 28.37 30.261-5.36 65.714-96.25 107.803-88.81 173.193l-433.54-1.12Z" transform="translate(-9365.68 -3850.18)scale(7.7439)" fill="#eeeeee" class="coloreeeeee svgShape"></path>
  <path d="M1717.45 829.9c0-3.197-1.36-6.262-3.78-8.523-2.42-2.26-5.7-3.53-9.13-3.53h-246.51c-3.43 0-6.71 1.27-9.13 3.53-2.42 2.261-3.78 5.326-3.78 8.523v281.38c0 3.2 1.36 6.26 3.78 8.52s5.7 3.53 9.13 3.53h246.51c3.43 0 6.71-1.27 9.13-3.53 2.42-2.26 3.78-5.32 3.78-8.52V829.9Z" transform="matrix(6.97645 0 -1.61552 7.46963 -5984.961 -4011.882)" fill="#4285f4" class="color6993a4 svgShape"></path>
  <path d="M1703.85 748.378c0-3.478-2.89-6.297-6.46-6.297h-18.99c-3.56 0-6.45 2.819-6.45 6.297v.474c0 3.477 2.89 6.296 6.45 6.296h18.99c3.57 0 6.46-2.819 6.46-6.296v-.474Z" transform="matrix(8.53726 0 -1.893 8.75262 -9911.056 -3776)" fill="#ffffff" class="colorffffff svgShape"></path>
  <path d="M1703.85 748.614c0-3.608-.9-6.532-2.01-6.533h-27.88c-1.11.001-2.01 2.925-2.01 6.533v.001c0 3.608.9 6.533 2.01 6.533h27.88c1.11 0 2.01-2.925 2.01-6.533v-.001Z" transform="matrix(16.14665 0 -1.0751 4.9709 -23286.698 -755.575)" fill="#ffffff" class="colorffffff svgShape"></path>
  <path d="M1703.85 748.614c0-3.608-.9-6.532-2.01-6.533h-27.88c-1.11.001-2.01 2.925-2.01 6.533v.001c0 3.608.9 6.533 2.01 6.533h27.88c1.11 0 2.01-2.925 2.01-6.533v-.001Z" transform="matrix(16.14665 0 -1.0751 4.9709 -23307.54 -659.21)" fill="#ffffff" class="colorffffff svgShape"></path>
  <path d="M1703.85 748.378c0-1.67-.36-3.272-1-4.452-.64-1.181-1.51-1.845-2.41-1.845h-25.08c-1.88 0-3.41 2.819-3.41 6.297v.474c0 1.669.36 3.271 1 4.452.64 1.18 1.51 1.844 2.41 1.844h25.08c1.88 0 3.41-2.819 3.41-6.296v-.474Z" transform="matrix(16.14665 0 -1.893 8.75262 -22793.562 -3035.681)" fill="#ffffff" class="colorffffff svgShape"></path>
  <path d="M1703.85 748.611c0-1.731-.08-3.392-.23-4.617-.15-1.225-.36-1.913-.57-1.913h-30.3c-.21 0-.42.688-.57 1.913-.14 1.225-.23 2.886-.23 4.617v.007c0 1.732.09 3.393.23 4.617.15 1.225.36 1.913.57 1.913h30.3c.21 0 .42-.688.57-1.913.15-1.224.23-2.885.23-4.617v-.007Z" transform="matrix(42.0888 0 -1.11147 5.1391 -66812.348 -54.62)" fill="#ffffff" class="colorffffff svgShape"></path>
  <path d="M1703.85 748.611c0-1.731-.08-3.392-.23-4.617-.15-1.225-.36-1.913-.57-1.913h-30.3c-.21 0-.42.688-.57 1.913-.14 1.225-.23 2.886-.23 4.617v.007c0 1.732.09 3.393.23 4.617.15 1.225.36 1.913.57 1.913h30.3c.21 0 .42-.688.57-1.913.15-1.224.23-2.885.23-4.617v-.007Z" transform="matrix(42.0888 0 -1.11147 5.1391 -66841.681 81.006)" fill="#ffffff" class="colorffffff svgShape"></path>
  <path d="M1703.85 748.611c0-1.731-.08-3.392-.23-4.617-.15-1.225-.36-1.913-.57-1.913h-30.3c-.21 0-.42.688-.57 1.913-.14 1.225-.23 2.886-.23 4.617v.007c0 1.732.09 3.393.23 4.617.15 1.225.36 1.913.57 1.913h30.3c.21 0 .42-.688.57-1.913.15-1.224.23-2.885.23-4.617v-.007Z" transform="matrix(42.0888 0 -1.11147 5.1391 -66871.014 216.633)" fill="#ffffff" class="colorffffff svgShape"></path>
  <path d="M1698.69 575.454c0-4.787 1.56-8.673 4.66-11.656 3.11-2.983 7.19-4.475 12.22-4.475 5.11 0 9.22 1.474 12.33 4.421 3.11 2.948 4.66 6.941 4.66 11.978v3.859c0 4.823-1.55 8.7-4.66 11.63-3.11 2.929-7.18 4.394-12.22 4.394-5.07 0-9.17-1.474-12.3-4.421-3.13-2.948-4.69-6.923-4.69-11.924v-3.806Zm10.29 4.127c0 2.144.62 3.868 1.85 5.172 1.23 1.304 2.85 1.956 4.85 1.956 2 0 3.59-.661 4.77-1.983 1.18-1.322 1.77-3.091 1.77-5.306v-3.966c0-2.143-.59-3.876-1.77-5.198-1.18-1.322-2.81-1.983-4.88-1.983-1.96 0-3.55.652-4.77 1.956-1.21 1.304-1.82 3.117-1.82 5.44v3.912Zm27.01 39.766c0-4.824 1.57-8.709 4.72-11.657 3.14-2.947 7.21-4.421 12.22-4.421 5.07 0 9.17 1.456 12.3 4.368 3.12 2.912 4.68 6.922 4.68 12.031v3.859c0 4.788-1.53 8.655-4.6 11.603-3.08 2.947-7.17 4.421-12.28 4.421-5.14 0-9.27-1.483-12.38-4.448-3.1-2.965-4.66-6.896-4.66-11.79v-3.966Zm10.29 4.18c0 1.965.64 3.644 1.93 5.038 1.29 1.393 2.89 2.09 4.82 2.09 4.36 0 6.54-2.412 6.54-7.235v-4.073c0-2.144-.61-3.868-1.82-5.172-1.21-1.304-2.82-1.956-4.82-1.956-2.01 0-3.61.652-4.83 1.956-1.21 1.304-1.82 3.082-1.82 5.333v4.019Zm-27.55 9.111-7.55-4.073 38.1-60.989 7.56 4.073-38.11 60.989Z" transform="matrix(-10.3432 -.02978 2.73296 -12.47039 20136.165 10745.317)" fill="#ffffff" fill-rule="nonzero" class="colorffffff svgShape"></path>
  <path d="M1573.45 946.389h-3.47v7.733h-4.35v-21.124h7.85c2.49 0 4.41.556 5.77 1.669 1.35 1.112 2.03 2.684 2.03 4.715 0 1.441-.31 2.643-.93 3.605-.63.962-1.57 1.729-2.84 2.299l4.57 8.633v.203h-4.67l-3.96-7.733Zm-3.47-3.525h3.51c1.09 0 1.94-.278 2.54-.835.6-.556.9-1.322.9-2.299 0-.996-.29-1.78-.85-2.35-.57-.571-1.44-.856-2.6-.856h-3.5v6.34ZM1591.54 954.412c-2.3 0-4.18-.706-5.62-2.118-1.45-1.412-2.17-3.294-2.17-5.644v-.406c0-1.577.3-2.986.91-4.229.61-1.243 1.47-2.2 2.59-2.873 1.12-.672 2.39-1.008 3.82-1.008 2.15 0 3.84.677 5.07 2.031 1.24 1.354 1.85 3.274 1.85 5.76v1.712H1588c.13 1.025.54 1.847 1.22 2.466.68.619 1.55.929 2.59.929 1.62 0 2.88-.586 3.79-1.756l2.06 2.307c-.63.89-1.48 1.584-2.55 2.082-1.08.498-2.27.747-3.57.747Zm-.48-12.883c-.83 0-1.51.28-2.02.841-.52.561-.85 1.364-1 2.409h5.83v-.334c-.02-.929-.27-1.647-.75-2.154-.49-.508-1.17-.762-2.06-.762ZM1608.87 949.784c0-.513-.25-.917-.76-1.212-.5-.295-1.32-.558-2.44-.79-3.74-.784-5.6-2.37-5.6-4.759 0-1.393.58-2.556 1.73-3.489 1.16-.933 2.67-1.4 4.54-1.4 1.99 0 3.58.469 4.78 1.407 1.19.938 1.79 2.157 1.79 3.656h-4.19c0-.599-.2-1.095-.59-1.487-.38-.391-.99-.587-1.81-.587-.7 0-1.25.159-1.64.478-.38.32-.58.726-.58 1.219 0 .464.22.839.66 1.124.44.286 1.18.532 2.23.74 1.04.208 1.92.443 2.64.704 2.21.812 3.32 2.22 3.32 4.222 0 1.431-.61 2.589-1.84 3.474-1.23.885-2.82 1.328-4.76 1.328-1.31 0-2.48-.235-3.5-.704s-1.82-1.112-2.41-1.929c-.57-.818-.86-1.7-.86-2.648h3.97c.04.745.31 1.315.83 1.712.51.397 1.2.595 2.06.595.8 0 1.41-.153 1.82-.457.41-.305.61-.704.61-1.197ZM1625.05 952.526c-1.03 1.257-2.47 1.886-4.29 1.886-1.69 0-2.97-.484-3.86-1.451-.88-.967-1.33-2.384-1.35-4.251v-10.286h4.19v10.141c0 1.635.75 2.452 2.24 2.452 1.42 0 2.39-.493 2.93-1.48v-11.113h4.2v15.698h-3.94l-.12-1.596ZM1636.21 938.424l.13 1.756c1.11-1.364 2.61-2.046 4.51-2.046 2.02 0 3.41.798 4.16 2.394 1.11-1.596 2.68-2.394 4.72-2.394 1.7 0 2.97.496 3.8 1.487.83.991 1.25 2.483 1.25 4.476v10.025h-4.21v-10.011c0-.89-.17-1.54-.52-1.951-.35-.411-.96-.617-1.85-.617-1.25 0-2.12.6-2.61 1.799l.02 10.78h-4.19v-9.996c0-.909-.18-1.567-.54-1.973-.36-.407-.97-.61-1.83-.61-1.19 0-2.05.494-2.58 1.48v11.099h-4.19v-15.698h3.93ZM1665.22 954.412c-2.3 0-4.17-.706-5.62-2.118-1.45-1.412-2.17-3.294-2.17-5.644v-.406c0-1.577.31-2.986.92-4.229.61-1.243 1.47-2.2 2.59-2.873 1.11-.672 2.39-1.008 3.82-1.008 2.15 0 3.84.677 5.07 2.031 1.23 1.354 1.85 3.274 1.85 5.76v1.712h-10c.14 1.025.55 1.847 1.23 2.466.68.619 1.54.929 2.59.929 1.61 0 2.88-.586 3.79-1.756l2.06 2.307c-.63.89-1.48 1.584-2.56 2.082-1.07.498-2.26.747-3.57.747Zm-.48-12.883c-.83 0-1.5.28-2.02.841-.52.561-.85 1.364-.99 2.409h5.83v-.334c-.02-.929-.27-1.647-.75-2.154-.49-.508-1.18-.762-2.07-.762Z" transform="matrix(7.7439 0 -1.67484 7.7439 -7291.194 -4921.336)" fill="#ffffff" fill-rule="nonzero" class="colorffffff svgShape"></path>
  <g transform="rotate(-46.718 2448.455 15075.397)scale(7.15034)" fill="#000000" class="color000000 svgShape">
    <path d="m1674.58 952.815-84.26-9.17-101.17-56.746s-39.61 50.548-18.16 83.749c14.93 23.121 92.18 57.782 119.78 45.502 56.84-25.286 107.22-28.685 109.73-47.932 0 0 3.96-10.811 4.81-14.305 7.18-29.391-3.81-29.279-3.81-29.279s-10.89 29.427-11.12 12.908c-.04-2.627-5.07-1.161-7.84 2.965-3.51 5.231-7.96 12.308-7.96 12.308Z" fill="#faeaba" class="colorfad8ba svgShape"></path>
    <clipPath id="a">
      <path d="m1674.58 952.815-84.26-9.17-101.17-56.746s-39.61 50.548-18.16 83.749c14.93 23.121 92.18 57.782 119.78 45.502 56.84-25.286 107.22-28.685 109.73-47.932 0 0 3.96-10.811 4.81-14.305 7.18-29.391-3.81-29.279-3.81-29.279s-10.89 29.427-11.12 12.908c-.04-2.627-5.07-1.161-7.84 2.965-3.51 5.231-7.96 12.308-7.96 12.308Z" fill="#000000" class="color000000 svgShape"></path>
    </clipPath>
    <g clip-path="url(#a)" fill="#000000" class="color000000 svgShape">
      <path d="M1696.54 935.918c11.1-27.386-17.24-45.209-19.7-37.477-12.32 38.681-38.18 68.333-57.48 80.273-8.52 5.264-17.92 9.254-27.69 11.446a449.87 449.87 0 0 1-8.34 1.792c-1.19.243-3.01.545-3.64 1.774-1.45 2.871 4.19 7.184 5.78 8.764 7.36 7.31 13.95 17.12 23.86 20.98 22.38 8.72 41.46-13.69 53.62-29.322a252.213 252.213 0 0 0 15.21-21.854c3.88-6.254 7.32-12.761 10.61-19.347 2.78-5.582 5.42-11.246 7.77-17.029Z" transform="matrix(.67528 .73756 -.77499 .70954 1238.13 -904.399)" fill="#d7c799" class="colord7b699 svgShape"></path>
      <path d="M1557.26 905.509c.19 2.483 2.49 6 3.17 8.535 1.78 6.664 2.64 13.772 2.07 20.659-1.06 12.922-10.08 26.195-4.68 39.214 7.1 17.132 32.67 13.343 32.95 34.533.03 2.94-.32 5.86-1.18 8.67-6.68 21.91-35.94 27.64-55.6 24.76-37.7-5.53-65.98-36.24-76.28-71.773-8.05-27.767-7.97-60.697 4.48-87.17 7.44-15.822 24.01-36.04 44-29.653 9.17 2.926 44.87 45.214 51.07 52.225Z" fill="#ea4335" class="colorf25c05 svgShape"></path>
    </g>
  </g>
  <g transform="matrix(6.78983 -3.72373 3.82692 6.97797 -9097.544 2622.967)" fill="#000000" class="color000000 svgShape">
    <path d="M1412.01 613.185c0-3.24-1.32-6.347-3.67-8.638a12.752 12.752 0 0 0-8.88-3.577h-4.9c-3.33 0-6.53 1.287-8.88 3.577-2.36 2.291-3.68 5.398-3.68 8.638v203.209c0 1.982.33 3.951.97 5.832 2.27 6.667 8.01 23.508 11.4 33.474.38 1.105 1.44 1.85 2.64 1.85 1.19 0 2.26-.745 2.63-1.85 3.4-9.966 9.14-26.807 11.41-33.474.64-1.881.96-3.85.96-5.832V613.185Z" fill="#024113" class="color023341 svgShape"></path>
    <clipPath id="b">
      <path d="M1412.01 613.185c0-3.24-1.32-6.347-3.67-8.638a12.752 12.752 0 0 0-8.88-3.577h-4.9c-3.33 0-6.53 1.287-8.88 3.577-2.36 2.291-3.68 5.398-3.68 8.638v203.209c0 1.982.33 3.951.97 5.832 2.27 6.667 8.01 23.508 11.4 33.474.38 1.105 1.44 1.85 2.64 1.85 1.19 0 2.26-.745 2.63-1.85 3.4-9.966 9.14-26.807 11.41-33.474.64-1.881.96-3.85.96-5.832V613.185Z" fill="#000000" class="color000000 svgShape"></path>
    </clipPath>
    <g clip-path="url(#b)" fill="#000000" class="color000000 svgShape">
      <path d="M1547.84 698.354c7.18 35.608 28.71 63.053 45.9 92.995 13.06 22.739 24.33 46.389 37.27 69.184 6.64 11.7 13.55 23.264 20.4 34.844 3.44 5.809 7.47 13.466 14.18 16.027 8.8 3.362 10.51-7.81 11.44-13.92.31-2.021.66-7.165 3.95-6.187 3.83 1.135 6.57 6.777 8.27 9.925 5.95 11.086 9.28 23.481 9.65 36.057.59 19.951-9.39 36.157-31.05 25.72-17.67-8.514-31.24-25.665-43.22-40.604-24.66-30.761-44-65.793-61.42-101.044-15.83-32.033-46.74-94.741-15.37-122.997Z" transform="matrix(.8768 .4679 -.48086 .85315 371.593 -729.355)" fill="#032f0f" class="color03222f svgShape"></path>
    </g>
  </g>
  <path d="M1412.01 625.531c0-13.565-6.71-24.561-15-24.561S1382 611.966 1382 625.531v135.674c0 13.565 6.72 24.562 15.01 24.562s15-10.997 15-24.562V625.531Z" transform="rotate(-28.742 4722.966 4672.836)scale(3.15615 1.92828)" fill="#ffffff" class="colorffffff svgShape"></path>
  <g transform="matrix(11.54453 0 0 5.72923 -14281.33 -1564.94)" fill="#000000" class="color000000 svgShape">
    <path d="M1445.12 821.351c-9.36-21.6-61.94-18.778-70.56 3.062-25.13 63.629-14.13 213.717-14.13 213.717l107.58 1.76c-14.1-35.75-7.31-182.626-22.89-218.539Z" fill="#ea4335" class="colorf25c05 svgShape"></path>
    <clipPath id="c">
      <path d="M1445.12 821.351c-9.36-21.6-61.94-18.778-70.56 3.062-25.13 63.629-14.13 213.717-14.13 213.717l107.58 1.76c-14.1-35.75-7.31-182.626-22.89-218.539Z" fill="#000000" class="color000000 svgShape"></path>
    </clipPath>
    <g clip-path="url(#c)" fill="#000000" class="color000000 svgShape">
      <path d="M1518.5 937.009c-15.98 40.979 26.82 68.501-17.51 112.561-10.38 10.32-4.79 18.48 6.3 29.93 16.44 16.97 50.83 2.54 58.59-15.35 29.23-67.457-47.87-113.04-47.38-127.141Z" transform="matrix(.61157 -.19738 .09796 1.23234 415.405 24.795)" fill="#d21000" class="colord23f00 svgShape"></path>
    </g>
  </g>
  <g transform="rotate(-20.73 -2545.86 27848.948)scale(7.15033)" fill="#000000" class="color000000 svgShape">
    <path d="m1635.94 885.06-45.62 58.585-101.17-56.746s-39.61 50.548-18.16 83.749c14.93 23.121 92.18 57.782 119.78 45.502 56.84-25.286 68.58-96.441 71.09-115.687 0 0 3.96-10.812 4.81-14.306 7.18-29.391-3.81-29.279-3.81-29.279s-13.61 27.875-13.84 11.356c-.03-2.626-3.69-4.05-6.46.075-3.52 5.232-6.62 16.751-6.62 16.751Z" fill="#faeaba" class="colorfad8ba svgShape"></path>
    <clipPath id="d">
      <path d="m1635.94 885.06-45.62 58.585-101.17-56.746s-39.61 50.548-18.16 83.749c14.93 23.121 92.18 57.782 119.78 45.502 56.84-25.286 68.58-96.441 71.09-115.687 0 0 3.96-10.812 4.81-14.306 7.18-29.391-3.81-29.279-3.81-29.279s-13.61 27.875-13.84 11.356c-.03-2.626-3.69-4.05-6.46.075-3.52 5.232-6.62 16.751-6.62 16.751Z" fill="#000000" class="color000000 svgShape"></path>
    </clipPath>
    <g clip-path="url(#d)" fill="#000000" class="color000000 svgShape">
      <path d="M1696.54 935.918c11.1-27.386-17.24-45.209-19.7-37.477-12.32 38.681-38.18 68.333-57.48 80.273-8.52 5.264-17.92 9.254-27.69 11.446a449.87 449.87 0 0 1-8.34 1.792c-1.19.243-3.01.545-3.64 1.774-1.45 2.871 4.19 7.184 5.78 8.764 7.36 7.31 13.95 17.12 23.86 20.98 22.38 8.72 41.46-13.69 53.62-29.322a252.213 252.213 0 0 0 15.21-21.854c3.88-6.254 7.32-12.761 10.61-19.347 2.78-5.582 5.42-11.246 7.77-17.029Z" transform="translate(-14.814)" fill="#d7c799" class="colord7b699 svgShape"></path>
      <path d="M1557.26 905.509c.19 2.483 2.49 6 3.17 8.535 1.78 6.664 2.64 13.772 2.07 20.659-1.06 12.922-10.08 26.195-4.68 39.214 7.1 17.132 32.67 13.343 32.95 34.533.03 2.94-.32 5.86-1.18 8.67-6.68 21.91-35.94 27.64-55.6 24.76-37.7-5.53-65.98-36.24-76.28-71.773-8.05-27.767-7.97-60.697 4.48-87.17 7.44-15.822 24.01-36.04 44-29.653 9.17 2.926 44.87 45.214 51.07 52.225Z" fill="#ea4335" class="colorf25c05 svgShape"></path>
    </g>
  </g>
  <g transform="matrix(7.15034 0 0 7.24417 -8286.676 -3400.52)" fill="#000000" class="color000000 svgShape">
    <path d="M1452.17 868.038h-24.68c2.64 9.967-3.16 18.047-6.5 24.708 6.97 13.364 25.94 7.772 30.99-1.53-4.78-9.556-4.15-15.621.19-23.178Z" fill="#faeaba" class="colorfad8ba svgShape"></path>
    <clipPath id="e">
      <path d="M1452.17 868.038h-24.68c2.64 9.967-3.16 18.047-6.5 24.708 6.97 13.364 25.94 7.772 30.99-1.53-4.78-9.556-4.15-15.621.19-23.178Z" fill="#000000" class="color000000 svgShape"></path>
    </clipPath>
    <g clip-path="url(#e)" fill="#000000" class="color000000 svgShape">
      <path d="M1451.32 848.04c.52 1.182-3.32 7.779-2.66 8.887 1.61 2.694 3.32 5.313 5.22 7.814 1.81 2.392 3.8 4.785 6.07 6.772 2.15 1.886 4.74 3.432 7.3 4.712 1.06.53 2.42 1.191 3.64.879 1.59-.407 2.23-2.736 2.63-4.073 1.32-4.396.9-9.559-.69-13.82-3.2-8.613-12.67-13.321-21.51-11.171Z" transform="matrix(.99891 -.04606 .0514 1.08607 -59.873 5.98)" fill="#d7c799" class="colord7b699 svgShape"></path>
    </g>
  </g>
  <path d="M1442.84 817.929c13.32 0 24.14 11.287 24.14 25.189 0 13.903-1.49 26.516-14.81 26.516s-33.47-12.613-33.47-26.516c0-13.902 10.82-25.189 24.14-25.189Z" transform="matrix(6.10657 0 0 7.15034 -6770.567 -3230.463)" fill="#faeaba" class="colorfad8ba svgShape"></path>
  <path d="M1459.78 831.959c-.39-1.82-.6-3.709-.6-5.646 0-14.619 11.87-26.488 26.49-26.488s26.48 11.869 26.48 26.488-11.86 26.488-26.48 26.488c-.43 0-.86-.01-1.28-.03a16.427 16.427 0 0 1 1.28 6.362c0 9.056-7.36 16.409-16.41 16.409-4.44 0-8.48-1.769-11.43-4.641a10.078 10.078 0 0 1-4.64 1.126c-5.58 0-10.11-4.531-10.11-10.112 0-4.763 3.3-8.762 7.74-9.831a13.611 13.611 0 0 1-1.75-6.71c0-6.547 4.58-12.032 10.71-13.415Z" transform="translate(-9365.68 -3850.18)scale(7.7439)" fill="#032f0f" class="color03222f svgShape"></path>
  <g transform="translate(-7157.363 -2455.351)scale(6.44542)" fill="#000000" class="color000000 svgShape">
    <path d="M1826.95 1063.05c.53-6.86 2.82-13.69 4.99-20.17 5.79-17.25 14.13-32.74 28.91-43.864 7.18-5.402 16.92-10.461 26.23-9.185 4.41.603 9.33 3.149 9.11 8.246-.38 9.113-11.31 16.233-17.99 20.663-16.32 10.83-46.62 22.56-51.25 44.31Z" fill="#4285f4" class="color6993a4 svgShape"></path>
    <clipPath id="f">
      <path d="M1826.95 1063.05c.53-6.86 2.82-13.69 4.99-20.17 5.79-17.25 14.13-32.74 28.91-43.864 7.18-5.402 16.92-10.461 26.23-9.185 4.41.603 9.33 3.149 9.11 8.246-.38 9.113-11.31 16.233-17.99 20.663-16.32 10.83-46.62 22.56-51.25 44.31Z" fill="#000000" class="color000000 svgShape"></path>
    </clipPath>
    <g clip-path="url(#f)" fill="#000000" class="color000000 svgShape">
      <path d="M1855.6 999.788c1.04 2.592.6 5.662.06 8.312-.48 2.39-1.15 4.82-2.38 6.94-4.46 7.66-13.84 10.88-22.14 12.14-3.75.57-9.76.95-12.7-2.13-2.02-2.12-.56-4.16-.44-6.54.03-.63-.47-.78-1-.62-2.87.84-5.33 4.93-6.87 7.2-4.62 6.85-7.57 15.14-8.79 23.29-.43 2.87-1.07 6.88.78 9.42 2.32 3.19 7.6.75 10.29-.51.78-.37 1.56-.76 2.33-1.16.89-.46 1.78-.94 2.65-1.42 1.37-.75 2.71-1.55 4.04-2.35 8.13-4.86 46.98-25.05 52.1-34.6 5.34-9.97-8.7-14.59-17.93-17.972Z" transform="translate(-337.245 -216.062)scale(1.20146)" fill="#34a853" class="color477282 svgShape"></path>
    </g>
  </g>
  <g transform="matrix(-6.44542 0 0 6.44542 16361.204 -2455.351)" fill="#000000" class="color000000 svgShape">
    <path d="M1826.95 1063.05c.53-6.86 2.82-13.69 4.99-20.17 5.79-17.25 14.13-32.74 28.91-43.864 7.18-5.402 16.92-10.461 26.23-9.185 4.41.603 9.33 3.149 9.11 8.246-.38 9.113-11.31 16.233-17.99 20.663-16.32 10.83-46.62 22.56-51.25 44.31Z" fill="#4285f4" class="color6993a4 svgShape"></path>
    <clipPath id="g">
      <path d="M1826.95 1063.05c.53-6.86 2.82-13.69 4.99-20.17 5.79-17.25 14.13-32.74 28.91-43.864 7.18-5.402 16.92-10.461 26.23-9.185 4.41.603 9.33 3.149 9.11 8.246-.38 9.113-11.31 16.233-17.99 20.663-16.32 10.83-46.62 22.56-51.25 44.31Z" fill="#000000" class="color000000 svgShape"></path>
    </clipPath>
    <g clip-path="url(#g)" fill="#000000" class="color000000 svgShape">
      <path d="M1855.6 999.788c1.04 2.592.6 5.662.06 8.312-.48 2.39-1.15 4.82-2.38 6.94-4.46 7.66-13.84 10.88-22.14 12.14-3.75.57-9.76.95-12.7-2.13-2.02-2.12-.56-4.16-.44-6.54.03-.63-.47-.78-1-.62-2.87.84-5.33 4.93-6.87 7.2-4.62 6.85-7.57 15.14-8.79 23.29-.43 2.87-1.07 6.88.78 9.42 2.32 3.19 7.6.75 10.29-.51.78-.37 1.56-.76 2.33-1.16.89-.46 1.78-.94 2.65-1.42 1.37-.75 2.71-1.55 4.04-2.35 8.13-4.86 46.98-25.05 52.1-34.6 5.34-9.97-8.7-14.59-17.93-17.972Z" transform="translate(-337.245 -216.062)scale(1.20146)" fill="#34a853" class="color477282 svgShape"></path>
    </g>
  </g>
  <g transform="matrix(8.55027 0 0 8.31882 -11020.102 -4467.92)" fill="#000000" class="color000000 svgShape">
    <path d="M1830.61 1062.95c-.26-10.01-.87-20.78.25-31.11 1.07-9.78 3.69-19.17 9.96-26.97 6.79-8.459 16.47-13.765 25.14-19.935 9.65-6.873 18.1-14.74 21.35-27.711.99-3.91 1.36-7.975.98-11.995-.41-4.286-1.79-8.419-3.64-12.283-.89-1.862-3.09-2.627-4.9-1.709-1.81.918-2.56 3.175-1.66 5.036 1.46 3.054 2.59 6.308 2.92 9.696.3 3.143-.01 6.319-.78 9.376-2.78 11.05-10.21 17.553-18.44 23.408-9.21 6.558-19.4 12.339-26.62 21.327-14.03 17.48-12.43 41.85-11.88 63.07.06 2.08 1.74 3.72 3.76 3.66 2.02-.05 3.61-1.78 3.56-3.86Z" fill="#4285f4" class="color6993a4 svgShape"></path>
    <clipPath id="h">
      <path d="M1830.61 1062.95c-.26-10.01-.87-20.78.25-31.11 1.07-9.78 3.69-19.17 9.96-26.97 6.79-8.459 16.47-13.765 25.14-19.935 9.65-6.873 18.1-14.74 21.35-27.711.99-3.91 1.36-7.975.98-11.995-.41-4.286-1.79-8.419-3.64-12.283-.89-1.862-3.09-2.627-4.9-1.709-1.81.918-2.56 3.175-1.66 5.036 1.46 3.054 2.59 6.308 2.92 9.696.3 3.143-.01 6.319-.78 9.376-2.78 11.05-10.21 17.553-18.44 23.408-9.21 6.558-19.4 12.339-26.62 21.327-14.03 17.48-12.43 41.85-11.88 63.07.06 2.08 1.74 3.72 3.76 3.66 2.02-.05 3.61-1.78 3.56-3.86Z" fill="#000000" class="color000000 svgShape"></path>
    </clipPath>
    <g clip-path="url(#h)" fill="#000000" class="color000000 svgShape">
      <path d="M1847.02 924.905c5.25 5.935 2.64 36.785 5.98 43.864.79 1.693 1.42 7.919 3.45 8.598 1.57.522 3.33-1.597 4.19-2.574 3.06-3.452 5.16-7.904 7.03-12.068 4.85-10.735 8.71-23.987 7.13-35.85-.26-2.003-.72-4.053-1.52-5.914-3.52-8.121-12.71-5.808-18.62-2.034-2.73 1.749-5.23 3.807-7.64 5.978Z" transform="matrix(.89406 -.14872 .1447 .91894 83.332 350.673)" fill="#34a853" class="color477282 svgShape"></path>
    </g>
  </g>
  <g transform="translate(-14192.826 -6270.406)scale(10.2475)" fill="#000000" class="color000000 svgShape">
    <circle cx="1873.49" cy="922.267" r="28.654" fill="#fbbc05" class="colorf29f05 svgShape"></circle>
    <clipPath id="i">
      <circle cx="1873.49" cy="922.267" r="28.654" fill="#000000" class="color000000 svgShape"></circle>
    </clipPath>
    <g clip-path="url(#i)" fill="#000000" class="color000000 svgShape">
      <path d="M1078.06 1036.13c3.78 18.66 2.57 41.21-14.47 53.1a42.774 42.774 0 0 1-10.56 5.33c-9.42 3.22-20.72 3.17-29.76-1.21-2.66-1.28-5.19-2.91-7.34-4.94-1.35-1.27-2.69-3.39-4.37-4.22-1.67-.83-2.13 1.29-2.03 2.49.36 4.52 3.42 9 6.17 12.4 10.58 13.09 28.05 16.93 43.83 11.83 27.21-8.79 41.45-49.94 18.53-74.78Z" transform="translate(1082.17 116.823)scale(.75569)" fill="#d9a100" class="colord98a00 svgShape"></path>
    </g>
  </g>
  <path d="m1886.04 843.909 1.66 10.676 10.68 1.659-10.68 1.658-1.66 10.676-1.66-10.676-10.67-1.658 10.67-1.659 1.66-10.676Z" transform="translate(-7977.59 -3154.344)scale(6.99145)" fill="#fbbc05" class="colorf29f05 svgShape"></path>
  <path d="m1886.04 843.909 1.66 10.676 10.68 1.659-10.68 1.658-1.66 10.676-1.66-10.676-10.67-1.658 10.67-1.659 1.66-10.676Z" transform="translate(-2416.305 -768.707)scale(4.10456)" fill="#fbbc05" class="colorf29f05 svgShape"></path>
  <path d="m1886.04 843.909 1.66 10.676 10.68 1.659-10.68 1.658-1.66 10.676-1.66-10.676-10.67-1.658 10.67-1.659 1.66-10.676Z" transform="translate(-2416.305 -578.267)scale(4.10456)" fill="#fbbc05" class="colorf29f05 svgShape"></path>
  <path d="M1754.55 918.17c0-2.929-.81-5.261-2.44-6.993-1.62-1.733-4.38-3.332-8.28-4.797-3.89-1.465-7.25-2.921-10.07-4.368-2.83-1.447-5.25-3.108-7.27-4.984a20.055 20.055 0 0 1-4.71-6.619c-1.13-2.536-1.69-5.555-1.69-9.057 0-6.038 1.93-10.986 5.79-14.845 3.86-3.859 8.98-6.109 15.38-6.753v-11.468h8.57v11.629c6.33.893 11.28 3.528 14.85 7.905 3.57 4.377 5.36 10.049 5.36 17.016h-15.49c0-4.288-.89-7.494-2.65-9.62-1.77-2.126-4.14-3.189-7.1-3.189-2.93 0-5.2.831-6.81 2.492-1.61 1.662-2.41 3.957-2.41 6.887 0 2.715.78 4.895 2.36 6.538 1.57 1.644 4.49 3.323 8.76 5.038 4.27 1.715 7.78 3.332 10.53 4.85 2.75 1.518 5.07 3.233 6.97 5.145a19.971 19.971 0 0 1 4.34 6.538c1 2.448 1.5 5.297 1.5 8.548 0 6.074-1.9 11.005-5.68 14.792-3.79 3.787-9.01 6.02-15.65 6.699v10.665h-8.52v-10.612c-7.33-.786-13-3.385-17.02-7.797-4.02-4.413-6.03-10.281-6.03-17.605h15.49c0 4.251 1.01 7.511 3.03 9.78 2.02 2.269 4.92 3.403 8.71 3.403 3.14 0 5.62-.83 7.45-2.492 1.82-1.661 2.73-3.903 2.73-6.726Z" transform="rotate(-30 5455.454 5948.287)scale(3.69919)" fill="#ffffff" fill-rule="nonzero" class="colorffffff svgShape"></path>
  <path d="M1358.95 1066.85h457.854v8.317H1358.95z" transform="matrix(-7.7439 0 0 2.79947 14943.011 1392.385)" fill="#032f0f" class="color03222f svgShape"></path>
  <path d="M1358.95 1066.85h457.854v8.317H1358.95z" transform="matrix(-.82971 0 0 2.97514 6045.223 1207.902)" fill="#032f0f" class="color03222f svgShape"></path>
  <circle cx="1388.3" cy="841.972" r="37.582" transform="translate(-9856.239 -4287.308)scale(8.17423)" fill="#859cc2" class="color85b1c2 svgShape"></circle>
  <path d="m1337.82 833.121 11.42 15.851a6.41 6.41 0 0 0 5.37 2.656 6.435 6.435 0 0 0 5.24-2.93l22.93-35.621a6.313 6.313 0 0 0-1.95-8.762c-2.98-1.883-6.94-1.016-8.84 1.936l-17.84 27.701-5.91-8.204c-2.05-2.85-6.05-3.513-8.93-1.478a6.31 6.31 0 0 0-1.49 8.851Z" transform="matrix(6.97567 0 0 7.0388 -7996.393 -3229.269)" fill="#ffffff" class="colorffffff svgShape"></path>
</svg>

        </div>
    </div>
</section>

<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-12px); }
}
.animate-float {
    animation: float 5s ease-in-out infinite;
}
</style>


    {{-- Features Section --}}
    <section id="features" class="bg-[#F7D9F1] py-20">
        <div class="max-w-[1200px] mx-auto text-center px-6">
            <h2 class="font-[Playfair_Display] text-4xl md:text-5xl font-bold mb-4 text-[#1C1C3C]">Everything You Need to Land the Job</h2>
            <p class="font-[Inter] text-lg md:text-xl text-[#1C1C3C]/80 mb-12 max-w-[800px] mx-auto">
                Our smart tools combine AI and design excellence to create the ultimate resume experience.
            </p>

            <div class="grid md:grid-cols-3 gap-8">
                {{-- Templates --}}
                <div class="bg-white rounded-2xl p-8 flex flex-col items-center text-center shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-20 h-20 mb-5 bg-[#F7D9F1] rounded-full flex items-center justify-center">
                        <svg class="w-11 h-11 text-[#1C1C3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-3zM14 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1h-4a1 1 0 01-1-1v-3z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-semibold mb-3 text-[#1C1C3C]">Smart Resume Templates</h3>
                    <p class="text-base text-[#1C1C3C]/80 leading-relaxed">
                        Choose from several modern, ATS-friendly templates built by hiring experts to impress recruiters instantly.
                    </p>
                </div>

                {{-- template's feature 1 --}}
                <div class="bg-white rounded-2xl p-8 flex flex-col items-center text-center shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-20 h-20 mb-5 bg-[#F7D9F1] rounded-full flex items-center justify-center">
                        <svg class="w-11 h-11 text-[#1C1C3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-semibold mb-3 text-[#1C1C3C]">AI Resume Analyzer</h3>
                    <p class="text-base text-[#1C1C3C]/80 leading-relaxed">
                        Upload your existing resume and get an instant score with feedback on keywords, tone, and formatting — powered by machine learning.
                    </p>
                </div>

                {{-- template's feature 2 --}}
                <div class="bg-white rounded-2xl p-8 flex flex-col items-center text-center shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-20 h-20 mb-5 bg-[#F7D9F1] rounded-full flex items-center justify-center">
                        <svg class="w-11 h-11 text-[#1C1C3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-semibold mb-3 text-[#1C1C3C]">Auto-Formatting Engine</h3>
                    <p class="text-base text-[#1C1C3C]/80 leading-relaxed">
                        Spend less time aligning margins. Our AI engine adjusts your layout for perfect spacing, style, and readability — instantly.
                    </p>
                </div>
            </div>

            {{-- template's feature 3 --}}
            <div class="mt-12 text-center">
                <p class="text-lg text-[#1C1C3C]/80 mb-4 max-w-[650px] mx-auto">
                    Why wait longer? Find out more about what our powerful AI-driven features can do for you.
                </p>
                <a href="{{ url('/features') }}" class="inline-block bg-[#1C1C3C] text-white px-8 py-3 rounded-xl text-lg font-semibold hover:bg-[#FF6F61] transition-all duration-300 shadow-lg hover:shadow-xl">
                    Explore Features
                </a>
            </div>
        </div>
    </section>

    {{-- Templates Section --}}
    <section id="templates" class="bg-[#DAD9F7] py-20">
        <div class="max-w-[1200px] mx-auto text-center px-6">
            <h2 class="font-[Playfair_Display] text-4xl md:text-5xl font-bold mb-4 text-[#1C1C3C]">Professional Resume Templates</h2>
            <p class="text-lg md:text-xl mb-12 text-[#1C1C3C]/80 max-w-[800px] mx-auto">
                Pick from styles that recruiters love. Designed for clarity, professionalism, and elegance.
            </p>

            <div class="grid md:grid-cols-3 gap-8">
                {{-- Modern --}}
                <div class="bg-white rounded-2xl shadow-lg p-8 flex flex-col items-center text-center hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-20 h-20 mb-5 bg-[#DAD9F7] rounded-full flex items-center justify-center">
                        <svg class="w-11 h-11 text-[#1C1C3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-semibold mb-3 text-[#1C1C3C]">Modern</h3>
                    <p class="text-base text-[#1C1C3C]/80 leading-relaxed">Clean lines, subtle colors, and great readability. Ideal for tech and design professionals.</p>
                </div>

                {{-- Classic --}}
                <div class="bg-white rounded-2xl shadow-lg p-8 flex flex-col items-center text-center hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-20 h-20 mb-5 bg-[#DAD9F7] rounded-full flex items-center justify-center">
                        <svg class="w-11 h-11 text-[#1C1C3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-semibold mb-3 text-[#1C1C3C]">Classic</h3>
                    <p class="text-base text-[#1C1C3C]/80 leading-relaxed">Timeless layout trusted by recruiters in corporate, law, and academic industries.</p>
                </div>

                {{-- Creative --}}
                <div class="bg-white rounded-2xl shadow-lg p-8 flex flex-col items-center text-center hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-20 h-20 mb-5 bg-[#DAD9F7] rounded-full flex items-center justify-center">
                        <svg class="w-11 h-11 text-[#1C1C3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-semibold mb-3 text-[#1C1C3C]">Creative</h3>
                    <p class="text-base text-[#1C1C3C]/80 leading-relaxed">Bold, vibrant, and personal. Perfect for marketing, media, and creative arts fields.</p>
                </div>
            </div>

            {{-- CTA under templates --}}
            <div class="mt-12 text-center">
                <p class="text-lg text-[#1C1C3C]/80 mb-4 max-w-[750px] mx-auto">
                    We currently offer popular templates like <strong>Classic</strong>, <strong>Modern</strong>, <strong>Minimalist</strong>, <strong>Elegant</strong>, and <strong>Creative</strong>.
                    But don't worry — we're actively working to add even more designs to suit your needs.
                </p>
                <a href="{{ url('/test') }}" class="inline-block bg-[#1C1C3C] text-white px-8 py-3 rounded-xl text-lg font-semibold hover:bg-[#FF6F61] transition-all duration-300 shadow-lg hover:shadow-xl">
                    View All Templates
                </a>
            </div>
        </div>
    </section>


    {{-- CTA Final --}}
    <section class="bg-[#FFE1AF] py-20 text-center">
        <div class="max-w-[850px] mx-auto px-6">
            <h2 class="text-4xl md:text-5xl font-[Playfair_Display] mb-4 text-[#1C1C3C]">Ready to Build Your Resume?</h2>
            <p class="text-lg md:text-xl text-[#1C1C3C]/80 mb-8">Start creating your AI-powered resume today. It's fast, easy, and free to begin.</p>
            <a href="{{ route('register') }}" class="inline-block bg-[#FF6F61] text-white px-10 py-4 rounded-lg text-lg font-semibold hover:bg-[#FF8C7A] transition-all duration-300 shadow-lg hover:shadow-xl">
                Get Started Free
            </a>
            <p class="text-sm text-[#1C1C3C]/60 mt-6">
                Have suggestions? Contact us via the details at the bottom — we'd love your feedback.
            </p>
        </div>
    </section>
@endsection

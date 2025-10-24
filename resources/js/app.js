import './bootstrap';

import Alpine from 'alpinejs';

import resumeBuilder from './alpine/resumeBuilder.js';

window.Alpine = Alpine;
Alpine.data('resumeBuilder', resumeBuilder);
Alpine.start();

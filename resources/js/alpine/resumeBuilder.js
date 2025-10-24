export default function resumeBuilder() {
  return {
    showPreview: false,
    activeTab: 'personal',
    resume: {
      personal: { name: '', title: '', email: '', phone: '', location: '' },
      summary: '',
      experience: [],
      education: [],
      skills: [],
      projects: [],
      languages: []
    },
    addItem(section) {
      const templates = {
        experience: { position: '', company: '', location: '', startDate: '', endDate: '', description: '' },
        education: { institution: '', degree: '', field: '', startDate: '', endDate: '' }
      };
      this.resume[section].push(templates[section]);
    },
    removeItem(section, index) {
      this.resume[section].splice(index, 1);
    }
  };
}


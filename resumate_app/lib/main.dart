import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Resumate',
      theme: ThemeData(
        colorScheme: ColorScheme.fromSeed(seedColor: Colors.deepPurple),
        textTheme: GoogleFonts.poppinsTextTheme(),
        useMaterial3: true,
      ),
      home: const HomeScreen(),
    );
  }
}

class HomeScreen extends StatelessWidget {
  const HomeScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text(
          'Resumate',
          style: GoogleFonts.playfairDisplay(
            fontSize: 24,
            fontWeight: FontWeight.w700,
          ),
        ),
        backgroundColor: Colors.deepPurple,
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.stretch,
          children: [
            const SizedBox(height: 12),
            Text(
              'Let\'s Get Started',
              style: GoogleFonts.playfairDisplay(
                fontSize: 32,
                fontWeight: FontWeight.w700,
              ),
            ),
            const SizedBox(height: 8),
            Text(
              'Choose how you\'d like to begin',
              style: GoogleFonts.inter(fontSize: 16),
            ),
            const SizedBox(height: 24),
            Expanded(
              child: Row(
                children: [
                  Expanded(
                    child: ChoiceCard(
                      title: 'Create New',
                      subtitle: 'Start fresh with guided steps',
                      color: Colors.deepPurple.shade100,
                      onTap: () => Navigator.push(
                        context,
                        MaterialPageRoute(
                          builder: (_) => const ResumeBuilderPage(),
                        ),
                      ),
                    ),
                  ),
                  const SizedBox(width: 12),
                  Expanded(
                    child: ChoiceCard(
                      title: 'Upload Existing',
                      subtitle: 'Import and enhance your resume',
                      color: Colors.pink.shade100,
                      onTap: () => ScaffoldMessenger.of(context).showSnackBar(
                        const SnackBar(
                          content: Text('Upload not implemented yet'),
                        ),
                      ),
                    ),
                  ),
                ],
              ),
            ),
            const SizedBox(height: 16),
            ElevatedButton(
              onPressed: () => Navigator.push(
                context,
                MaterialPageRoute(builder: (_) => const ResumeBuilderPage()),
              ),
              style: ElevatedButton.styleFrom(
                padding: const EdgeInsets.symmetric(vertical: 16),
              ),
              child: const Text('Proceed', style: TextStyle(fontSize: 18)),
            ),
            const SizedBox(height: 12),
          ],
        ),
      ),
    );
  }
}

class ChoiceCard extends StatelessWidget {
  final String title;
  final String subtitle;
  final Color color;
  final VoidCallback onTap;

  const ChoiceCard({
    super.key,
    required this.title,
    required this.subtitle,
    required this.color,
    required this.onTap,
  });

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: onTap,
      child: Container(
        margin: const EdgeInsets.symmetric(vertical: 8),
        padding: const EdgeInsets.all(18),
        decoration: BoxDecoration(
          color: color,
          borderRadius: BorderRadius.circular(16),
          boxShadow: [
            BoxShadow(color: Colors.black.withOpacity(0.05), blurRadius: 12),
          ],
        ),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const SizedBox(height: 6),
            Text(
              title,
              style: GoogleFonts.poppins(
                fontSize: 22,
                fontWeight: FontWeight.w600,
              ),
            ),
            const SizedBox(height: 8),
            Text(
              subtitle,
              style: GoogleFonts.inter(fontSize: 14, color: Colors.black87),
            ),
            const Spacer(),
            const Align(
              alignment: Alignment.bottomRight,
              child: Icon(Icons.arrow_forward, color: Colors.black54),
            ),
          ],
        ),
      ),
    );
  }
}

// Data models for sections/steps
class ResumeSection {
  final String name;
  final List<ResumeStep> steps;
  ResumeSection({required this.name, required this.steps});
}

class ResumeStep {
  final String id;
  final String label;
  final String type; // text | textarea | email | tel
  final String placeholder;
  final bool required;

  ResumeStep({
    required this.id,
    required this.label,
    this.type = 'text',
    this.placeholder = '',
    this.required = false,
  });
}

class ResumeBuilderPage extends StatefulWidget {
  const ResumeBuilderPage({super.key});

  @override
  State<ResumeBuilderPage> createState() => _ResumeBuilderPageState();
}

class _ResumeBuilderPageState extends State<ResumeBuilderPage> {
  final List<ResumeSection> sections = [
    ResumeSection(
      name: 'Personal Info',
      steps: [
        ResumeStep(
          id: 'firstName',
          label: 'What\'s your first name?',
          placeholder: 'John',
          required: true,
        ),
        ResumeStep(
          id: 'lastName',
          label: 'And your last name?',
          placeholder: 'Doe',
          required: true,
        ),
        ResumeStep(
          id: 'email',
          label: 'Your email address?',
          type: 'email',
          placeholder: 'john.doe@example.com',
          required: true,
        ),
        ResumeStep(
          id: 'phone',
          label: 'Phone number?',
          type: 'tel',
          placeholder: '+1 (555) 123-4567',
          required: true,
        ),
        ResumeStep(
          id: 'city',
          label: 'Which city are you in?',
          placeholder: 'New York',
          required: false,
        ),
      ],
    ),
    ResumeSection(
      name: 'Education',
      steps: [
        ResumeStep(
          id: 'degree',
          label: 'What\'s your degree?',
          placeholder: 'Bachelor of Science',
          required: true,
        ),
        ResumeStep(
          id: 'school',
          label: 'Which school?',
          placeholder: 'University of California',
          required: true,
        ),
        ResumeStep(
          id: 'graduationYear',
          label: 'Graduation year?',
          placeholder: '2020',
          required: true,
        ),
        ResumeStep(
          id: 'major',
          label: 'Your major?',
          placeholder: 'Computer Science',
          required: false,
        ),
      ],
    ),
    ResumeSection(
      name: 'Experience',
      steps: [
        ResumeStep(
          id: 'jobTitle',
          label: 'Most recent job title?',
          placeholder: 'Software Engineer',
          required: true,
        ),
        ResumeStep(
          id: 'company',
          label: 'Company name?',
          placeholder: 'Tech Corp',
          required: true,
        ),
        ResumeStep(
          id: 'duration',
          label: 'How long? (e.g., 2 years)',
          placeholder: '2 years',
          required: true,
        ),
        ResumeStep(
          id: 'responsibilities',
          label: 'Key responsibilities?',
          type: 'textarea',
          placeholder: 'Led development...',
          required: false,
        ),
      ],
    ),
    ResumeSection(
      name: 'Skills',
      steps: [
        ResumeStep(
          id: 'technicalSkills',
          label: 'Technical skills?',
          placeholder: 'Python, JavaScript, React',
          required: true,
        ),
        ResumeStep(
          id: 'softSkills',
          label: 'Soft skills?',
          placeholder: 'Communication, Leadership',
          required: false,
        ),
        ResumeStep(
          id: 'languages',
          label: 'Languages you speak?',
          placeholder: 'English, Spanish',
          required: false,
        ),
      ],
    ),
  ];

  int currentSection = 0;
  int currentStep = 0;
  final Map<String, String> formData = {};

  ResumeSection get sectionData => sections[currentSection];
  ResumeStep get stepData => sectionData.steps[currentStep];

  void nextStep() {
    if (stepData.required &&
        (formData[stepData.id] == null ||
            formData[stepData.id]!.trim().isEmpty)) {
      return;
    }
    setState(() {
      if (currentStep < sectionData.steps.length - 1) {
        currentStep++;
      } else if (currentSection < sections.length - 1) {
        currentSection++;
        currentStep = 0;
      } else {
        // Completed
        showDialog(
          context: context,
          builder: (_) => AlertDialog(
            title: const Text('Resume completed!'),
            content: Text(formData.toString()),
            actions: [
              TextButton(
                onPressed: () => Navigator.pop(context),
                child: const Text('OK'),
              ),
            ],
          ),
        );
      }
    });
  }

  void prevStep() {
    setState(() {
      if (currentStep > 0) {
        currentStep--;
      } else if (currentSection > 0) {
        currentSection--;
        currentStep = sections[currentSection].steps.length - 1;
      }
    });
  }

  double get sectionProgress => ((currentStep + 1) / sectionData.steps.length);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Resume Builder - ${sectionData.name}'),
        backgroundColor: Colors.deepPurple,
      ),
      body: SingleChildScrollView(
        child: Padding(
          padding: const EdgeInsets.all(16.0),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              // Progress card
              Card(
                elevation: 4,
                child: Padding(
                  padding: const EdgeInsets.all(12.0),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        'Format',
                        style: GoogleFonts.poppins(fontWeight: FontWeight.w600),
                      ),
                      const SizedBox(height: 8),
                      ClipRRect(
                        borderRadius: BorderRadius.circular(8),
                        child: Image.network(
                          'https://d.novoresume.com/images/doc/reverse-chronological-resume-template.png',
                          height: 120,
                          width: double.infinity,
                          fit: BoxFit.cover,
                        ),
                      ),
                      const SizedBox(height: 8),
                      LinearProgressIndicator(
                        value: sectionProgress,
                        color: Colors.deepPurple,
                      ),
                      const SizedBox(height: 8),
                      Text(
                        '${sectionData.name} • ${(sectionProgress * 100).round()}%',
                        style: GoogleFonts.inter(
                          fontSize: 12,
                          color: Colors.black54,
                        ),
                      ),
                    ],
                  ),
                ),
              ),
              const SizedBox(height: 16),

              // Question card
              Card(
                elevation: 2,
                child: Padding(
                  padding: const EdgeInsets.all(16.0),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        'Question ${currentStep + 1} of ${sectionData.steps.length}',
                        style: GoogleFonts.inter(
                          color: Colors.black54,
                          fontSize: 12,
                        ),
                      ),
                      const SizedBox(height: 8),
                      Text(
                        stepData.label,
                        style: GoogleFonts.playfairDisplay(
                          fontSize: 22,
                          fontWeight: FontWeight.w700,
                        ),
                      ),
                      const SizedBox(height: 12),
                      if (stepData.type == 'textarea')
                        TextFormField(
                          minLines: 4,
                          maxLines: 6,
                          initialValue: formData[stepData.id] ?? '',
                          onChanged: (v) => formData[stepData.id] = v,
                          decoration: InputDecoration(
                            border: const OutlineInputBorder(),
                            hintText: stepData.placeholder,
                          ),
                        )
                      else
                        TextFormField(
                          initialValue: formData[stepData.id] ?? '',
                          onChanged: (v) => formData[stepData.id] = v,
                          keyboardType: stepData.type == 'email'
                              ? TextInputType.emailAddress
                              : (stepData.type == 'tel'
                                    ? TextInputType.phone
                                    : TextInputType.text),
                          decoration: InputDecoration(
                            border: const OutlineInputBorder(),
                            hintText: stepData.placeholder,
                          ),
                        ),
                      const SizedBox(height: 16),
                      Row(
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        children: [
                          TextButton.icon(
                            onPressed: prevStep,
                            icon: const Icon(Icons.arrow_back),
                            label: const Text('Back'),
                          ),
                          ElevatedButton(
                            onPressed: () {
                              if (stepData.required &&
                                  (formData[stepData.id] == null ||
                                      formData[stepData.id]!.trim().isEmpty)) {
                                ScaffoldMessenger.of(context).showSnackBar(
                                  const SnackBar(
                                    content: Text(
                                      'Please fill this required field',
                                    ),
                                  ),
                                );
                                return;
                              }
                              nextStep();
                            },
                            child: Text(
                              (currentSection == sections.length - 1 &&
                                      currentStep ==
                                          sectionData.steps.length - 1)
                                  ? 'Complete'
                                  : 'Continue',
                            ),
                          ),
                        ],
                      ),
                    ],
                  ),
                ),
              ),
              const SizedBox(height: 24),

              // Section overview
              Wrap(
                spacing: 8,
                runSpacing: 8,
                children: List.generate(sections.length, (i) {
                  final s = sections[i];
                  final completed = i < currentSection;
                  return ChoiceChip(
                    label: Text(s.name),
                    selected: i == currentSection,
                    onSelected: (v) {
                      setState(() {
                        currentSection = i;
                        currentStep = 0;
                      });
                    },
                    selectedColor: Colors.deepPurple.shade100,
                    backgroundColor: completed
                        ? Colors.green.shade100
                        : Colors.grey.shade100,
                  );
                }),
              ),
              const SizedBox(height: 40),
            ],
          ),
        ),
      ),
    );
  }
}

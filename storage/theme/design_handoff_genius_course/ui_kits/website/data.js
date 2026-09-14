window.GeniusData = {
  img: 'https://jthemes.net/themes/html/genius-course/assets/img',
  nav: [
    { label: 'Home', screen: 'home', children: [
      { label: 'Home 1', screen: 'home' }, { label: 'Home 2', screen: 'home' },
      { label: 'Home 3', screen: 'home' }, { label: 'Home 4', screen: 'home' }
    ] },
    { label: 'About Us', screen: 'about' },
    { label: 'shop', screen: 'shop' },
    { label: 'Contact Us', screen: 'contact' },
    { label: 'Pages', screen: 'course', children: [
      { label: 'Teacher', screen: 'teacher' },
      { label: 'Course', screen: 'course' },
      { label: 'Course Details', screen: 'course' },
      { label: 'Blog', screen: 'blog' },
      { label: 'FAQ', screen: 'faq' }
    ] }
  ],
  socials: [
    { icon: 'fab fa-facebook-f', label: 'Facebook' },
    { icon: 'fab fa-twitter', label: 'Twitter' },
    { icon: 'fab fa-google-plus-g', label: 'Google Plus' }
  ],
  courses: [
    { image: 'https://jthemes.net/themes/html/genius-course/assets/img/course/c-1.jpg', price: '$99.00', category: 'Web Design', author: 'John Luis Fernandes',
      title: 'Fully Responsive Web Design & Development.', trending: true,
      metrics: [{ icon: 'fas fa-user', label: '1.220' }, { icon: 'fas fa-comment-dots', label: '1.015' }, { label: '125k Unrolled' }] },
    { image: 'https://jthemes.net/themes/html/genius-course/assets/img/course/c-2.jpg', price: '$99.00', category: 'Mobile Apps', author: 'Fernando Torres',
      title: 'Introduction to Mobile Application Development.',
      metrics: [{ icon: 'fas fa-user', label: '1.220' }, { icon: 'fas fa-comment-dots', label: '1.015' }, { label: '125k Unrolled' }] },
    { image: 'https://jthemes.net/themes/html/genius-course/assets/img/course/c-3.jpg', price: '$99.00', category: 'Motion Graphic', author: 'enny Garcias',
      title: 'Learning IOS Apps Programming & Development.',
      metrics: [{ icon: 'fas fa-user', label: '1.220' }, { icon: 'fas fa-comment-dots', label: '1.015' }, { label: '125k Unrolled' }] }
  ],
  bestCourses: ['bc-1','bc-2','bc-3','bc-4','bc-5','bc-6','bc-7','bc-8'].map(function (n, i) {
    return {
      image: 'https://jthemes.net/themes/html/genius-course/assets/img/course/' + n + '.jpg', price: '$99.00',
      title: 'Fully Responsive Web Design & Development.',
      category: 'Web Design', students: '250 Students',
      trending: i === 0 || i === 5
    };
  }),
  news: [
    { image: 'https://jthemes.net/themes/html/genius-course/assets/img/blog/lb-1.jpg', date: '26 April 2018', title: 'Affiliate Marketing A Beginner’s Guide.',
      metrics: [{ icon: 'fas fa-user', label: '1.220' }, { icon: 'fas fa-comment-dots', label: '1.015' }] },
    { image: 'https://jthemes.net/themes/html/genius-course/assets/img/blog/lb-2.jpg', date: '26 April 2018', title: 'No.1 The Best Online Course 2018.',
      metrics: [{ icon: 'fas fa-user', label: '1.220' }, { icon: 'fas fa-comment-dots', label: '1.015' }] }
  ],
  events: [
    { day: '22', month: 'April 2018', title: 'Fully Responsive Web Design & Development.', category: 'Web Design', author: 'Koke' },
    { day: '07', month: 'August 2018', title: 'Introduction to Mobile Application Development.', category: 'Web Design', author: 'Koke' },
    { day: '30', month: 'Sept 2018', title: 'IOS Apps Programming & Development.', category: 'Web Design', author: 'Koke' }
  ],
  products: ['bp-1','bp-2','bp-3','bp-4'].map(function (n) {
    return { image: 'https://jthemes.net/themes/html/genius-course/assets/img/product/' + n + '.png', title: 'Mobile Apps Books.', price: 'Start from $55.25' };
  }),
  teachers: [
    { image: 'https://jthemes.net/themes/html/genius-course/assets/img/teacher/tb-1.png', name: 'Daniel Alvares', designation: 'Mobile Apps' },
    { image: 'https://jthemes.net/themes/html/genius-course/assets/img/teacher/tb-2.png', name: 'Berliana Luis', designation: 'IOS App' },
    { image: 'https://jthemes.net/themes/html/genius-course/assets/img/teacher/tb-3.png', name: 'Juliana Hernandes', designation: 'Web Design' },
    { image: 'https://jthemes.net/themes/html/genius-course/assets/img/teacher/tb-4.png', name: 'Johansen Doe', designation: 'Graphic' }
  ],
  categories: [
    { icon: 'flaticon-technology', title: 'Responsive Website' },
    { icon: 'flaticon-app-store', title: 'IOS Applications' },
    { icon: 'flaticon-artist-tools', title: 'Graphic Design' },
    { icon: 'flaticon-business', title: 'Marketing' },
    { icon: 'flaticon-dna', title: 'Science' },
    { icon: 'flaticon-cogwheel', title: 'Enginering' },
    { icon: 'flaticon-favorites-button', title: 'Photography' },
    { icon: 'flaticon-technology-1', title: 'Mobile Application' }
  ],
  testimonials: [
    { name: 'Robertho Garcia', designation: 'Graphic Designer' },
    { name: 'Juliana Hernandes', designation: 'Web Designer' },
    { name: 'Daniel Alvares', designation: 'Mobile Developer' }
  ],
  counters: [
    { icon: 'flaticon-graduation-hat', value: '5', suffix: ' M+', label: 'Students Enrolled' },
    { icon: 'flaticon-book', value: '122', suffix: '.500+', label: 'Online Available Courses' },
    { icon: 'flaticon-favorites-button', value: '15', suffix: '.000+', label: 'Premium Quality Products' },
    { icon: 'flaticon-group', value: '7', suffix: '.500+', label: 'Teachers Registered' }
  ],
  faq: {
    tabs: ['GENERAL', 'COURSES', 'TEACHERS', 'EVENTS', 'OTHERS'],
    answer: 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam volutpat. Ut wisi enim ad minim veniam consectetuer adipiscing elit, sed diam nonummy.',
    questions: [
      'How to Register or Make An Account in Genius?',
      'What is Genius Courses?',
      'What Lorem Ipsum Dolor Sit Amet Consectuerer?',
      'Adipiscing Diamet Nonnumy Nibh Euismod?'
    ]
  },
  contact: [
    { icon: 'fas fa-map-marker-alt', lines: ['Primary: Last Vegas, 120 Graphic Street, US', 'Second: Califorinia, 88 Design Street, US'] },
    { icon: 'fas fa-phone', lines: ['Primary: (100) 3434 55666', 'Second: (20) 3434 9999'] },
    { icon: 'fas fa-envelope', lines: ['Primary: info@geniuscourse.com', 'Second: mail@genius.info'] }
  ],
  about: {
    image: 'https://jthemes.net/themes/html/genius-course/assets/img/about/abt.jpg',
    lede: 'We take our mission of increasing global access to quality education seriously. We connect learners to the best universities and institutions from around the world.',
    body: 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam volutpat. Ut wisi enim ad minim veniam. magna aliquam volutpat. Ut wisi enim ad minim veniam.',
    list: [
      'Professional And Experienced Since 1980',
      'We Connect Learners To The Best Universities From Around The World',
      'Our Mission Increasing Global Access To Quality Aducation',
      '100K Online Available Courses'
    ]
  },
  app: {
    image: 'https://jthemes.net/themes/html/genius-course/assets/img/about/ab-2.png',
    list: [
      'Professional And Experienced Since 1980',
      'Our Mission Increasing Global Access To Quality Aducation',
      '100K Online Available Courses'
    ]
  },
  sponsors: ['s-1','s-2','s-3','s-4','s-5','s-6'].map(function (n) { return 'https://jthemes.net/themes/html/genius-course/assets/img/sponsor/' + n + '.jpg'; }),
  footer: {
    blurb: 'We take our mission of increasing global access to quality education seriously.',
    legal: [{ label: 'License' }, { label: 'Privacy & Policy' }, { label: 'Term Of Service' }],
    copyright: '© 2018 - Designed & Developed by Jthemes Studio. All rights reserved'
  }
};

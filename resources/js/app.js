import Alpine from 'alpinejs';
import EasyMDE from 'easymde';
import 'easymde/dist/easymde.min.css';

window.themeController = () => ({
	theme: 'light',
	init() {
		const savedTheme = window.localStorage.getItem('portfolio-theme');
		const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

		this.theme = savedTheme || (systemPrefersDark ? 'dark' : 'light');
		this.applyTheme();
	},
	toggleTheme() {
		this.theme = this.theme === 'dark' ? 'light' : 'dark';
		this.applyTheme();
	},
	applyTheme() {
		document.documentElement.dataset.theme = this.theme;
		window.localStorage.setItem('portfolio-theme', this.theme);
	},
});

window.lazySections = () => ({
	loaded: {
		skills: false,
		projects: false,
		contact: false,
	},
	initObservers(refs) {
		if (!('IntersectionObserver' in window)) {
			this.loaded.skills = true;
			this.loaded.projects = true;
			this.loaded.contact = true;
			return;
		}

		const observer = new IntersectionObserver(
			(entries) => {
				entries.forEach((entry) => {
					if (!entry.isIntersecting) {
						return;
					}

					const sectionKey = entry.target.dataset.lazySection;
					if (sectionKey && this.loaded[sectionKey] === false) {
						this.loaded[sectionKey] = true;
					}

					observer.unobserve(entry.target);
				});
			},
			{ threshold: 0.18, rootMargin: '0px 0px 120px 0px' }
		);

		Object.values(refs).forEach((element) => {
			if (element) {
				observer.observe(element);
			}
		});
	},
});

window.heroTypewriter = (name, title) => ({
	displayText: '',
	fullText: `Hi, I'm ${name} | ${title}`,
	typingSpeed: 72,
	cursorSpeed: 420,
	cursorVisible: true,
	index: 0,
	init() {
		const typeTick = () => {
			if (this.index <= this.fullText.length) {
				this.displayText = this.fullText.slice(0, this.index);
				this.index += 1;
				window.setTimeout(typeTick, this.typingSpeed);
			}
		};

		typeTick();

		window.setInterval(() => {
			this.cursorVisible = !this.cursorVisible;
			const caret = document.querySelector('.type-caret');
			if (caret) {
				caret.style.opacity = this.cursorVisible ? '1' : '0';
			}
		}, this.cursorSpeed);
	},
	scrollToProjects() {
		const projectsSection = document.getElementById('projects');
		if (!projectsSection) {
			return;
		}

		projectsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
	},
});

window.slideInOnScroll = () => ({
	isVisible: false,
	observe(element) {
		if (!('IntersectionObserver' in window)) {
			this.isVisible = true;
			return;
		}

		const observer = new IntersectionObserver(
			(entries) => {
				entries.forEach((entry) => {
					if (entry.isIntersecting) {
						this.isVisible = true;
						observer.unobserve(entry.target);
					}
				});
			},
			{ threshold: 0.25 }
		);

		observer.observe(element);
	},
});

window.projectsShowcase = (filters) => ({
	activeFilter: filters?.[0] ?? 'All',
	filters,
	isVisible: false,
	observe(element) {
		if (!('IntersectionObserver' in window)) {
			this.isVisible = true;
			return;
		}

		const observer = new IntersectionObserver(
			(entries) => {
				entries.forEach((entry) => {
					if (entry.isIntersecting) {
						this.isVisible = true;
						observer.unobserve(entry.target);
					}
				});
			},
			{ threshold: 0.2 }
		);

		observer.observe(element);
	},
});

window.skillsShowcase = (skills, categories, maxExperience, avgProficiency) => ({
	skills,
	categories,
	maxExperience,
	avgProficiency,
	activeCategory: 'all',
	isVisible: false,
	displayLevels: {},
	displayYears: {},
	stats: {
		categories: 0,
		avgProficiency: 0,
	},
	filteredSkills() {
		if (this.activeCategory === 'all') {
			return this.skills;
		}

		return this.skills.filter((skill) => skill.category === this.activeCategory);
	},
	observe(element) {
		if (!('IntersectionObserver' in window)) {
			this.isVisible = true;
			this.startCounters();
			return;
		}

		const observer = new IntersectionObserver(
			(entries) => {
				entries.forEach((entry) => {
					if (entry.isIntersecting) {
						this.isVisible = true;
						this.startCounters();
						observer.unobserve(entry.target);
					}
				});
			},
			{ threshold: 0.2 }
		);

		observer.observe(element);
	},
	startCounters() {
		this.animateValue('categories', this.categories.length, 850);
		this.animateValue('avgProficiency', this.avgProficiency, 950);

		this.skills.forEach((skill, index) => {
			window.setTimeout(() => {
				this.animateSkill(skill.id, skill.level, skill.years);
			}, index * 90);
		});
	},
	animateSkill(id, levelTarget, yearsTarget) {
		this.animateMapValue(this.displayLevels, id, levelTarget, 820);
		this.animateMapValue(this.displayYears, id, yearsTarget, 760);
	},
	animateMapValue(targetMap, key, endValue, duration) {
		const startTime = performance.now();

		const tick = (now) => {
			const progress = Math.min((now - startTime) / duration, 1);
			const eased = 1 - Math.pow(1 - progress, 3);
			targetMap[key] = Math.round(endValue * eased);

			if (progress < 1) {
				window.requestAnimationFrame(tick);
			}
		};

		window.requestAnimationFrame(tick);
	},
	animateValue(statKey, endValue, duration) {
		const startTime = performance.now();

		const tick = (now) => {
			const progress = Math.min((now - startTime) / duration, 1);
			const eased = 1 - Math.pow(1 - progress, 3);
			this.stats[statKey] = Math.round(endValue * eased);

			if (progress < 1) {
				window.requestAnimationFrame(tick);
			}
		};

		window.requestAnimationFrame(tick);
	},
});

window.contactForm = () => ({
	form: {
		name: '',
		email: '',
		subject: '',
		message: '',
		website: '',
	},
	errors: {},
	isSubmitting: false,
	status: {
		message: '',
		ok: false,
	},
	validateField(field) {
		const value = this.form[field] ?? '';

		switch (field) {
			case 'name':
				if (!value) {
					this.errors.name = 'Name is required.';
				} else if (value.length < 2) {
					this.errors.name = 'Name must be at least 2 characters.';
				} else {
					delete this.errors.name;
				}
				break;
			case 'email': {
				const validEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
				if (!value) {
					this.errors.email = 'Email is required.';
				} else if (!validEmail) {
					this.errors.email = 'Email format is invalid.';
				} else {
					delete this.errors.email;
				}
				break;
			}
			case 'subject':
				if (value.length > 160) {
					this.errors.subject = 'Subject must not exceed 160 characters.';
				} else {
					delete this.errors.subject;
				}
				break;
			case 'message':
				if (!value) {
					this.errors.message = 'Message is required.';
				} else if (value.length < 12) {
					this.errors.message = 'Message must be at least 12 characters.';
				} else {
					delete this.errors.message;
				}
				break;
			default:
				break;
		}
	},
	validateAll() {
		this.validateField('name');
		this.validateField('email');
		this.validateField('subject');
		this.validateField('message');

		return Object.keys(this.errors).length === 0;
	},
	async submitForm() {
		this.status.message = '';

		if (!this.validateAll()) {
			this.status = {
				message: 'Please fix the highlighted fields.',
				ok: false,
			};
			return;
		}

		this.isSubmitting = true;

		try {
			const csrfToken = document.head.querySelector('meta[name=csrf-token]')?.content ?? '';

			const response = await fetch('/api/v1/contact', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
					'Accept': 'application/json',
					'X-CSRF-TOKEN': csrfToken,
				},
				body: JSON.stringify(this.form),
			});

			const payload = await response.json();

			if (!response.ok) {
				if (response.status === 422 && payload.errors) {
					this.errors = Object.fromEntries(
						Object.entries(payload.errors).map(([key, value]) => [key, value[0]])
					);
				}

				this.status = {
					message: payload.message || 'Unable to send your message right now.',
					ok: false,
				};

				return;
			}

			this.errors = {};
			this.form = {
				name: '',
				email: '',
				subject: '',
				message: '',
				website: '',
			};

			this.status = {
				message: payload.message || 'Message sent successfully.',
				ok: true,
			};

			if (typeof plausible !== 'undefined') {
				plausible('contact-form-sent');
			}
		} catch {
			this.status = {
				message: 'A network error occurred. Please try again.',
				ok: false,
			};
		} finally {
			this.isSubmitting = false;
		}
	},
});

window.initializePostEditor = () => {
	const bodyField = document.querySelector('#body');

	if (!bodyField || bodyField.dataset.easyMdeInitialized === 'true') {
		return;
	}

	bodyField.dataset.easyMdeInitialized = 'true';

	new EasyMDE({
		element: bodyField,
		autosave: false,
		spellChecker: false,
		status: false,
		toolbar: ['heading', '|', 'bold', 'italic', '|', 'unordered-list', 'ordered-list', 'code', 'quote', '|', 'link', 'image'],
	});
};

if (document.readyState === 'loading') {
	document.addEventListener('DOMContentLoaded', window.initializePostEditor, { once: true });
} else {
	window.initializePostEditor();
}

window.scrollToTop = () => ({
	isVisible: false,
	threshold: 300,
	isTopVisible: true,
	observer: null,
	init() {
		const updateVisibility = () => {
			this.isVisible = window.scrollY > this.threshold && !this.isTopVisible;
		};

		if ('IntersectionObserver' in window && this.$refs.topSentinel) {
			this.observer = new IntersectionObserver(
				(entries) => {
					entries.forEach((entry) => {
						this.isTopVisible = entry.isIntersecting;
						updateVisibility();
					});
				},
				{ threshold: 0 }
			);

			this.observer.observe(this.$refs.topSentinel);
		}

		window.addEventListener('scroll', updateVisibility, { passive: true });
		this.$watch('isTopVisible', updateVisibility);
		updateVisibility();

		this.$el.addEventListener(
			'alpine:destroy',
			() => {
				window.removeEventListener('scroll', updateVisibility);
				if (this.observer) {
					this.observer.disconnect();
				}
			},
			{ once: true }
		);
	},
	scrollToTop() {
		window.scrollTo({ top: 0, behavior: 'smooth' });
	},
});

window.blogReadingProgress = () => ({
	progress: 0,
	init() {
		const update = () => {
			const documentHeight = document.documentElement.scrollHeight - window.innerHeight;
			if (documentHeight <= 0) {
				this.progress = 0;
				return;
			}

			const nextProgress = (window.scrollY / documentHeight) * 100;
			this.progress = Math.max(0, Math.min(100, Math.round(nextProgress)));
		};

		window.addEventListener('scroll', update, { passive: true });
		window.addEventListener('resize', update);
		update();

		this.$el.addEventListener(
			'alpine:destroy',
			() => {
				window.removeEventListener('scroll', update);
				window.removeEventListener('resize', update);
			},
			{ once: true }
		);
	},
});

window.testimonialsCarousel = (testimonials) => ({
	testimonials,
	currentIndex: 0,
	autoAdvanceId: null,
	prefersReducedMotion: false,
	get currentTestimonial() {
		return this.testimonials[this.currentIndex] ?? this.testimonials[0] ?? null;
	},
	init() {
		this.prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

		if (!this.prefersReducedMotion && this.testimonials.length > 1) {
			this.autoAdvanceId = window.setInterval(() => {
				this.next();
			}, 5000);
		}

		this.$el.addEventListener(
			'alpine:destroy',
			() => {
				if (this.autoAdvanceId) {
					window.clearInterval(this.autoAdvanceId);
				}
			},
			{ once: true }
		);
	},
	goTo(index) {
		if (!this.testimonials.length) {
			return;
		}

		this.currentIndex = (index + this.testimonials.length) % this.testimonials.length;
	},
	next() {
		this.goTo(this.currentIndex + 1);
	},
	previous() {
		this.goTo(this.currentIndex - 1);
	},
});

window.testimonialReorder = () => ({
	draggedRow: null,
	sortUrl: '',
	init() {
		const sortTarget = this.$el.querySelector('[data-sort-url]');
		this.sortUrl = sortTarget?.dataset.sortUrl ?? '';

		this.$el.querySelectorAll('[data-testimonial-id]').forEach((row) => {
			row.addEventListener('dragstart', () => {
				this.draggedRow = row;
				row.classList.add('opacity-50');
			});

			row.addEventListener('dragend', () => {
				row.classList.remove('opacity-50');
				this.draggedRow = null;
			});

			row.addEventListener('dragover', (event) => {
				event.preventDefault();
			});

			row.addEventListener('drop', async (event) => {
				event.preventDefault();

				if (!this.draggedRow || this.draggedRow === row) {
					return;
				}

				row.parentNode.insertBefore(this.draggedRow, row);
				await this.persistOrder();
			});
		});
	},
	async persistOrder() {
		if (!this.sortUrl) {
			return;
		}

		const rows = Array.from(this.$el.querySelectorAll('[data-testimonial-id]'));
		const order = rows.map((row) => Number(row.dataset.testimonialId));
		const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

		await fetch(this.sortUrl, {
			method: 'PATCH',
			headers: {
				'Content-Type': 'application/json',
				'X-CSRF-TOKEN': csrfToken ?? '',
				Accept: 'application/json',
			},
			body: JSON.stringify({ order }),
		});
	},
});

window.navController = () => ({
	sections: ['about', 'skills', 'projects', 'testimonials', 'contact'],
	activeSection: 'about',
	isDrawerOpen: false,
	isNavVisible: true,
	lastScrollY: 0,
	observer: null,
	init() {
		this.lastScrollY = window.scrollY;

		const handleScroll = () => {
			const currentScrollY = window.scrollY;

			if (currentScrollY < 80) {
				this.isNavVisible = true;
			} else {
				this.isNavVisible = currentScrollY < this.lastScrollY;
			}

			this.lastScrollY = currentScrollY;
		};

		window.addEventListener('scroll', handleScroll, { passive: true });

		if ('IntersectionObserver' in window) {
			this.observer = new IntersectionObserver(
				(entries) => {
					const visibleEntries = entries
						.filter((entry) => entry.isIntersecting)
						.sort((a, b) => b.intersectionRatio - a.intersectionRatio);

					if (visibleEntries.length > 0) {
						this.activeSection = visibleEntries[0].target.id;
					}
				},
				{
					threshold: [0.2, 0.35, 0.5, 0.75],
					rootMargin: '-20% 0px -55% 0px',
				}
			);

			this.sections.forEach((sectionId) => {
				const element = document.getElementById(sectionId);
				if (element) {
					this.observer.observe(element);
				}
			});
		}

		const handleResize = () => {
			if (window.innerWidth >= 768) {
				this.isDrawerOpen = false;
			}
		};

		window.addEventListener('resize', handleResize);

		this.$el.addEventListener(
			'alpine:destroy',
			() => {
				window.removeEventListener('scroll', handleScroll);
				window.removeEventListener('resize', handleResize);

				if (this.observer) {
					this.observer.disconnect();
				}
			},
			{ once: true }
		);
	},
	toggleDrawer() {
		this.isDrawerOpen = !this.isDrawerOpen;
	},
	closeDrawer() {
		this.isDrawerOpen = false;
	},
});

window.Alpine = Alpine;
Alpine.start();

if ('serviceWorker' in navigator) {
	window.addEventListener('load', () => {
		navigator.serviceWorker.register('/sw.js').catch(() => {
			// Service worker registration failure should not break app usage.
		});
	});
}

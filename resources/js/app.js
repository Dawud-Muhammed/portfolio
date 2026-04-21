import Alpine from 'alpinejs';
import EasyMDE from 'easymde';
import 'easymde/dist/easymde.min.css';

const THEME_STORAGE_KEY = 'portfolio-theme';

const readStoredTheme = () => {
	try {
		return window.localStorage.getItem(THEME_STORAGE_KEY);
	} catch {
		return null;
	}
};

const writeStoredTheme = (theme) => {
	try {
		window.localStorage.setItem(THEME_STORAGE_KEY, theme);
	} catch {
		// Ignore localStorage errors in private mode or restricted contexts.
	}
};

window.themeController = () => ({
	theme: 'system',
	systemThemeMediaQuery: null,
	mediaQueryChangeHandler: null,
	init() {
		const savedTheme = readStoredTheme();
		this.theme = this.isValidTheme(savedTheme) ? savedTheme : 'system';

		this.systemThemeMediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
		this.mediaQueryChangeHandler = () => {
			if (this.theme === 'system') {
				this.applyTheme();
			}
		};

		if (typeof this.systemThemeMediaQuery.addEventListener === 'function') {
			this.systemThemeMediaQuery.addEventListener('change', this.mediaQueryChangeHandler);
		} else {
			this.systemThemeMediaQuery.addListener(this.mediaQueryChangeHandler);
		}

		this.$el.addEventListener(
			'alpine:destroy',
			() => {
				if (!this.systemThemeMediaQuery || !this.mediaQueryChangeHandler) {
					return;
				}

				if (typeof this.systemThemeMediaQuery.removeEventListener === 'function') {
					this.systemThemeMediaQuery.removeEventListener('change', this.mediaQueryChangeHandler);
				} else {
					this.systemThemeMediaQuery.removeListener(this.mediaQueryChangeHandler);
				}
			},
			{ once: true }
		);

		this.applyTheme();
	},
	isValidTheme(theme) {
		return ['system', 'dark', 'light'].includes(theme);
	},
	setTheme(theme) {
		if (!this.isValidTheme(theme)) {
			return;
		}

		this.theme = theme;
		this.applyTheme();
	},
	resolveTheme() {
		if (this.theme === 'system') {
			return this.systemThemeMediaQuery?.matches ? 'dark' : 'light';
		}

		return this.theme;
	},
	applyTheme() {
		const resolvedTheme = this.resolveTheme();
		document.documentElement.dataset.theme = resolvedTheme;
		document.documentElement.dataset.themePreference = this.theme;
		writeStoredTheme(this.theme);
		window.dispatchEvent(
			new CustomEvent('theme-mode-updated', {
				detail: {
					theme: this.theme,
					resolvedTheme,
				},
			})
		);
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
	initialsFor(name) {
		if (!name || typeof name !== 'string') {
			return '--';
		}

		return name
			.trim()
			.split(/\s+/)
			.map((part) => part[0])
			.slice(0, 2)
			.join('')
			.toUpperCase();
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

window.navController = (config = {}) => ({
	sections: ['about', 'skills', 'projects', 'testimonials', 'contact'],
	activeSection: 'top',
	isDrawerOpen: false,
	isThemeMenuOpen: false,
	selectedTheme: 'system',
	isNavVisible: true,
	lastScrollY: 0,
	isHomeRoute: Boolean(config.isHomeRoute),
	homeUrl: typeof config.homeUrl === 'string' ? config.homeUrl : '/',
	linkCatalog: Array.isArray(config.linkCatalog) ? config.linkCatalog : [],
	quickQuery: '',
	observer: null,
	themeUpdateHandler: null,
	lastKnownHash: '',
	init() {
		this.lastScrollY = window.scrollY;
		this.syncFromLocation();

		const savedTheme = readStoredTheme();
		this.selectedTheme = ['system', 'dark', 'light'].includes(savedTheme) ? savedTheme : 'system';

		this.themeUpdateHandler = (event) => {
			const nextTheme = event?.detail?.theme;
			if (['system', 'dark', 'light'].includes(nextTheme)) {
				this.selectedTheme = nextTheme;
			}
		};

		window.addEventListener('theme-mode-updated', this.themeUpdateHandler);

		const handleScroll = () => {
			const currentScrollY = window.scrollY;

			if (currentScrollY < 48) {
				this.isNavVisible = true;
			} else {
				this.isNavVisible = currentScrollY <= this.lastScrollY;
			}

			this.lastScrollY = currentScrollY;
		};

		const handleHashChange = () => this.syncFromLocation();

		window.addEventListener('scroll', handleScroll, { passive: true });
		window.addEventListener('hashchange', handleHashChange, { passive: true });

		if ('IntersectionObserver' in window) {
			this.observer = new IntersectionObserver(
				(entries) => {
					const visibleEntries = entries
						.filter((entry) => entry.isIntersecting)
						.sort((a, b) => b.intersectionRatio - a.intersectionRatio);

					if (visibleEntries.length > 0) {
						this.activeSection = visibleEntries[0].target.id;
						this.lastKnownHash = this.activeSection;
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

		this.$watch('isDrawerOpen', (isOpen) => {
			document.body.classList.toggle('overflow-hidden', isOpen);

			if (isOpen) {
				this.$nextTick(() => {
					const firstFocusable = this.$refs.firstMobileLink ?? this.$refs.mobileNavSearch;
					firstFocusable?.focus();
				});
			} else {
				this.$nextTick(() => {
					this.$refs.drawerToggle?.focus();
				});
			}
		});

		window.addEventListener('resize', handleResize);

		this.$el.addEventListener(
			'alpine:destroy',
			() => {
				window.removeEventListener('scroll', handleScroll);
				window.removeEventListener('resize', handleResize);
				window.removeEventListener('hashchange', handleHashChange);
				document.body.classList.remove('overflow-hidden');
				if (this.themeUpdateHandler) {
					window.removeEventListener('theme-mode-updated', this.themeUpdateHandler);
				}

				if (this.observer) {
					this.observer.disconnect();
				}
			},
			{ once: true }
		);
	},
	syncFromLocation() {
		const hash = window.location.hash.replace('#', '').trim().toLowerCase();
		if (!hash) {
			this.activeSection = 'top';
			this.lastKnownHash = 'top';
			return;
		}

		this.activeSection = hash;
		this.lastKnownHash = hash;
	},
	toAbsoluteHref(href) {
		if (typeof href !== 'string' || href.length === 0) {
			return this.homeUrl;
		}

		if (href.startsWith('#')) {
			return `${this.homeUrl}${href}`;
		}

		return href;
	},
	normalizeKey(value) {
		return String(value ?? '')
			.trim()
			.toLowerCase();
	},
	isLinkActive(href) {
		const normalizedHref = this.toAbsoluteHref(href);
		const hash = normalizedHref.includes('#') ? normalizedHref.split('#')[1] : '';
		if (!hash) {
			return this.activeSection === 'top';
		}

		return this.activeSection === hash;
	},
	runQuickSearch() {
		const query = this.normalizeKey(this.quickQuery);
		if (!query) {
			return;
		}

		const matchedLink = this.linkCatalog.find((link) => {
			const label = this.normalizeKey(link?.label);
			const href = this.normalizeKey(link?.href);
			return label === query || label.includes(query) || href.includes(`#${query}`);
		});

		if (!matchedLink?.href) {
			return;
		}

		const nextHref = this.toAbsoluteHref(matchedLink.href);
		window.location.href = nextHref;
		this.closeDrawer();
		this.quickQuery = '';
	},
	toggleThemeMenu() {
		this.isThemeMenuOpen = !this.isThemeMenuOpen;
	},
	closeThemeMenu() {
		this.isThemeMenuOpen = false;
	},
	selectTheme(theme) {
		if (!['system', 'dark', 'light'].includes(theme)) {
			return;
		}

		this.selectedTheme = theme;
		this.closeThemeMenu();
		this.$dispatch('theme-change-request', { theme });
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

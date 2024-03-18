/* eslint-env node */
require('@rushstack/eslint-patch/modern-module-resolution.js')

module.exports = {
  root: true,
  extends: [
    'plugin:vue/vue3-recommended',
    '@vue/eslint-config-airbnb-with-typescript'
  ],
  parserOptions: {
    ecmaVersion: 'latest'
  },
  rules: {
    'no-console': 'error',
    'no-debugger': 'error',
    'vue/block-lang': ['error',
      {
        script: {
          lang: 'ts'
        }
      }
    ],
    '@typescript-eslint/indent': 'off',
    'vue/script-indent': ['error', 2, {
      // baseIndent: 1  // return after moving to vue3
    }],
    '@typescript-eslint/semi': 'off',
    semi: ['error', 'never'],
    '@typescript-eslint/comma-dangle': 'off',
    'comma-dangle': ['error', {
      arrays: 'never',
      objects: 'never',
      imports: 'never',
      exports: 'never',
      functions: 'never'
    }],
    'import/extensions': ['error', 'always'],
    'vue/multi-word-component-names': 'off',
    'import/prefer-default-export': 'off',
    'vue/max-len': ['error', { code: 150, ignoreHTMLAttributeValues: true }],
    'vue/order-in-components': ['error', {
      order: [
        'el',
        'name',
        'key',
        'parent',
        'functional',
        ['delimiters', 'comments'],
        ['components', 'directives', 'filters'],
        'extends',
        'mixins',
        ['provide', 'inject'],
        'ROUTER_GUARDS',
        'layout',
        'middleware',
        'validate',
        'scrollToTop',
        'transition',
        'loading',
        'inheritAttrs',
        'model',
        ['props', 'propsData'],
        'emits',
        'setup',
        'asyncData',
        'data',
        'fetch',
        'head',
        'computed',
        'watch',
        'watchQuery',
        'LIFECYCLE_HOOKS',
        'methods',
        ['template', 'render'],
        'renderError'
      ]
    }],
    'vue/attributes-order': ['error', {
      order: [
        'DEFINITION',
        'LIST_RENDERING',
        'CONDITIONALS',
        'RENDER_MODIFIERS',
        'GLOBAL',
        ['UNIQUE', 'SLOT'],
        'TWO_WAY_BINDING',
        'OTHER_DIRECTIVES',
        'OTHER_ATTR',
        'EVENTS',
        'CONTENT'
      ],
      alphabetical: false
    }],
    'vue/html-self-closing': ['error', {
      html: {
        void: 'always',
        normal: 'always',
        component: 'always'
      },
      svg: 'always',
      math: 'always'
    }],
    'vue/valid-v-slot': 'off',
    'lines-between-class-members': [
      'error',
      {
        enforce: [
          { blankLine: 'always', prev: '*', next: 'method' },
          { blankLine: 'always', prev: 'method', next: '*' },
          { blankLine: 'always', prev: 'field', next: 'field' }
        ]
      },
      { exceptAfterSingleLine: true }
    ]

  }
}

module.exports = {
    testEnvironment: "jsdom",
    testMatch: ["**/tests/**/*.test.js"],
    collectCoverageFrom: [
        "JS/**/*.js",
        "!JS/node_modules/**"
    ]
};
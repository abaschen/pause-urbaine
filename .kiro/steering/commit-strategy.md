---
inclusion: always
---

# Commit Strategy

## Commit After Every Task

Always create a Git commit after completing each task or subtask. This ensures:
- Clear history of changes
- Easy rollback if needed
- Better collaboration
- Incremental progress tracking

## Commit Message Format

Follow Conventional Commits format:

```
<type>(<scope>): <subject>

[optional body]

[optional footer]
```

### Types
- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation changes
- `style`: Code style changes (formatting, no logic change)
- `refactor`: Code refactoring
- `perf`: Performance improvements
- `test`: Adding or updating tests
- `chore`: Maintenance tasks (dependencies, config)
- `build`: Build system changes
- `ci`: CI/CD changes

### Examples

```bash
# After completing a task
git add .
git commit -m "feat(header): add bilingual header with location info

- Add header-top with both salon locations
- Include phone and Instagram links with Font Awesome icons
- Add language switcher
- Implement responsive design for mobile

Refs: Task 11"
```

```bash
# Simple commit
git commit -m "feat(i18n): add French translation file"
```

```bash
# Configuration change
git commit -m "chore(hugo): configure multilingual support

- Set defaultContentLanguage to fr
- Enable defaultContentLanguageInSubdir
- Configure fr and en languages

Refs: Task 2"
```

```bash
# Bug fix
git commit -m "fix(mobile-menu): correct toggle icon behavior

- Fix icon not switching between bars and times
- Add proper event listener cleanup

Refs: Task 21"
```

## When to Commit

### Commit After:
- Completing a subtask (e.g., "1.1 Install Hugo")
- Creating a new file or template
- Implementing a feature
- Fixing a bug
- Updating configuration
- Adding documentation

### Batch Commits (Optional):
For very small related changes, you can batch 2-3 subtasks into one commit:

```bash
git commit -m "chore(setup): initialize project structure

- Install Hugo extended
- Create directory structure
- Initialize Git repository
- Add .gitignore

Refs: Tasks 1.1-1.4"
```

## Commit Workflow

```bash
# 1. Check status
git status

# 2. Stage changes
git add .
# or stage specific files
git add path/to/file

# 3. Commit with message
git commit -m "type(scope): subject"

# 4. Push regularly (after every few commits)
git push origin main
```

## Best Practices

1. **Commit early, commit often**: Don't wait to accumulate many changes
2. **Keep commits focused**: One logical change per commit
3. **Write clear messages**: Future you will thank present you
4. **Reference tasks**: Include task number in commit message or body
5. **Test before committing**: Ensure code works before committing
6. **Push regularly**: Don't keep commits local for too long

## What NOT to Commit

- Sensitive data (API keys, passwords)
- Large binary files (unless necessary)
- Generated files (node_modules/, public/, .DS_Store)
- Personal IDE settings (unless team-agreed)
- Temporary files

## Git Ignore

Ensure `.gitignore` includes:

```gitignore
# Hugo
/public/
/resources/_gen/
/.hugo_build.lock

# Dependencies
node_modules/
package-lock.json

# OS
.DS_Store
Thumbs.db

# IDE
.vscode/
.idea/
*.swp
*.swo

# Logs
*.log

# Environment
.env
.env.local
```

## Amending Commits

If you forgot something in the last commit (not yet pushed):

```bash
# Make your changes
git add .

# Amend the last commit
git commit --amend --no-edit

# Or amend with new message
git commit --amend -m "new message"
```

⚠️ **Never amend commits that have been pushed to shared branches!**

## Example Workflow for a Task

```bash
# Task 11.1: Create header partial
touch layouts/partials/header.html
# ... edit file ...
git add layouts/partials/header.html
git commit -m "feat(header): create header partial template

Refs: Task 11.1"

# Task 11.2: Add header-top section
# ... edit file ...
git add layouts/partials/header.html
git commit -m "feat(header): add header-top with locations bar

- Loop through locations data
- Display location names

Refs: Task 11.2"

# Continue for each subtask...
```

## Summary

- ✅ Commit after every task/subtask
- ✅ Use conventional commit format
- ✅ Write clear, descriptive messages
- ✅ Reference task numbers
- ✅ Push regularly
- ❌ Don't commit sensitive data
- ❌ Don't commit generated files
- ❌ Don't amend pushed commits
